<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Log;

class XenditController extends Controller
{
    public function callback(Request $request)
    {
        // Simpan log payload webhook untuk debugging (opsional)
        Log::info('Xendit Callback Received:', $request->all());

        // Ambil ID eksternal dan status dari Xendit
        $externalId = $request->external_id ?? null;
        $status = $request->status ?? null;

        if (!$externalId || !$status) {
            return response()->json(['error' => 'Invalid callback data'], 400);
        }

        // Ambil ID pesanan dari external_id
        $orderId = str_replace('order-', '', $externalId);
        $order = Pesanan::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Proses status pembayaran
        if ($status === 'PAID') {
            $order->status_pembayaran = 'paid';
        } elseif ($status === 'EXPIRED' || $status === 'FAILED') {
            $order->status_pembayaran = strtolower($status);
        } else {
            $order->status_pembayaran = 'pending';
        }

        $order->save();

        return response()->json(['message' => 'Payment status updated']);
    }
    public function handleWebhook(Request $request)
{
    // Menangani notifikasi status pembayaran dari Xendit
    $data = $request->all();

    if ($data['status'] == 'PAID') {
        // Update status pembayaran pesanan
        $pesanan = Pesanan::where('external_id', $data['external_id'])->first();
        $pesanan->status_pembayaran = 'Lunas';
        $pesanan->save();
    }

    return response()->json(['status' => 'success']);
}

}
