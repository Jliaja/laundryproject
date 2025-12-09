<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|integer'
        ]);

        $pesanan = Pesanan::find($request->pesanan_id);

        if (!$pesanan) {
            return response()->json([
                "error" => "Pesanan tidak ditemukan dengan ID: " . $request->pesanan_id
            ], 404);
        }

        // SET MIDTRANS
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // GENERATE ORDER ID UNIK
        $orderId = "ORDER-" . $pesanan->id . "-" . uniqid();

        // SIMPAN ORDER ID KE DATABASE
        $pesanan->order_id = $orderId;
        $pesanan->save();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $pesanan->total_harga,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama_pelanggan ?? 'User Laundry',
            ]
        ];

        try {
            $snap = Snap::createTransaction($params);

            return response()->json([
                'order_id' => $orderId,
                'token' => $snap->token,
                'redirect_url' => $snap->redirect_url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Gagal membuat transaksi Midtrans: " . $e->getMessage()
            ], 500);
        }
    }
}
