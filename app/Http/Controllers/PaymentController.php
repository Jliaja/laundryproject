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
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $pesanan = Pesanan::find($request->pesanan_id);

    if (!$pesanan->order_id) {
        $pesanan->order_id = 'ORDER-' . time() . '-' . rand(1000, 9999);
        $pesanan->save();
    }

    $params = [
        'transaction_details' => [
            'order_id' => $pesanan->order_id,
            'gross_amount' => (int) $pesanan->total_harga,
        ],
        'customer_details' => [
            'first_name' => $pesanan->nama_pelanggan,
            'email' => $request->email ?? $pesanan->user->email ?? '',
            'phone' => $request->phone ?? '',
        ],
    ];

    try {
        $snapToken = Snap::getSnapToken($params);
        return response()->json(['snap_token' => $snapToken]);
    } catch (\Exception $e) {
        \Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
        return response()->json(['error' => 'Gagal mendapatkan snap token'], 500);
    }
}
    

    public function showBayarPage($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('user.pembayaran', compact('pesanan'));
    }
}
