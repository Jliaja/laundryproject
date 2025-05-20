<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pesanan;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $pesanan = Pesanan::find($request->pesanan_id);
        if (!$pesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->order_id,
                'gross_amount' => $pesanan->total_harga,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama_pelanggan,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
