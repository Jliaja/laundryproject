<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function callback(Request $request)
    {
        Log::info("Midtrans Callback: " . json_encode($request->all()));

        $data = json_decode($request->getContent());

        if (!$data || !isset($data->order_id)) {
            Log::error("Callback tidak mengandung order_id");
            return response()->json(['message' => 'Data tidak valid'], 400);
        }

        $orderId = $data->order_id;
        $transactionStatus = $data->transaction_status ?? '';
        $fraudStatus = $data->fraud_status ?? '';

        $pesanan = Pesanan::where('order_id', $orderId)->first();

        if (!$pesanan) {
            Log::error("Pesanan tidak ditemukan, order_id: $orderId");
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        switch ($transactionStatus) {

            case 'capture':
                if ($fraudStatus === 'challenge') {
                    $pesanan->status_pembayaran = 'pending';
                    $pesanan->status = 'proses';
                } else {
                    $pesanan->status_pembayaran = 'settlement';
                    $pesanan->status = 'proses';
                }
                break;

            case 'settlement':
                $pesanan->status_pembayaran = 'settlement';
                $pesanan->status = 'proses';
                break;

            case 'pending':
                $pesanan->status_pembayaran = 'pending';
                $pesanan->status = 'menunggu pembayaran';
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $pesanan->status_pembayaran = 'gagal';
                $pesanan->status = 'batal';
                break;

            default:
                Log::warning("Status transaksi tidak dikenali: $transactionStatus");
                break;
        }

        $pesanan->save();

        return response()->json(['message' => 'Callback berhasil diproses']);
    }
}
