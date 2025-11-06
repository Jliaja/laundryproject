<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        // Simulasi transaksi
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat',
            'transaction_id' => rand(1000, 9999),
            'payment_url' => 'https://sandbox.midtrans.com/pay/12345'
        ]);
    }

    public function callback(Request $request)
    {
        // Terima callback Midtrans
        return response()->json(['status' => 'callback diterima']);
    }
}
