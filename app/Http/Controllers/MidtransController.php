<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Notification;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notification = new Notification();

        // Ambil data dari notifikasi
        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $orderId = $notification->order_id;

        // Log request untuk debugging
        Log::info('Midtrans Callback Received:', $request->all());

        // Ambil ID dari order_id format: ORDER-123-1715244800
        preg_match('/ORDER-(\d+)-/', $orderId, $matches);
        $pesananId = $matches[1] ?? null;

        if (!$pesananId) {
            Log::error('Order ID tidak valid: ' . $orderId);
            return response()->json(['message' => 'Invalid order ID'], 400);
        }

        $pesanan = Pesanan::find($pesananId);
        if (!$pesanan) {
            Log::error('Pesanan tidak ditemukan untuk ID: ' . $pesananId);
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Update status pembayaran dan status pesanan berdasarkan status transaksi
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $pesanan->status_pembayaran = 'pending';
                } else {
                    $pesanan->status_pembayaran = 'Lunas';
                    $pesanan->status = 'proses';
                }
            }
        } elseif ($transaction == 'settlement') {
            $pesanan->status_pembayaran = 'Lunas';
            $pesanan->status = 'proses';
        } elseif ($transaction == 'pending') {
            $pesanan->status_pembayaran = 'pending';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $pesanan->status_pembayaran = 'gagal';
            $pesanan->status = 'batal';
        }

        // Simpan status pesanan
        $pesanan->save();

        Log::info('Status pesanan diperbarui: ', $pesanan->toArray());

        // Kirim response sukses
        return response()->json(['message' => 'Notifikasi diterima dan diproses']);
    }
}
