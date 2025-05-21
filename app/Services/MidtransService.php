<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pesanan;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createPayment(Pesanan $pesanan)
    {
        $orderId = 'ORDER-' . $pesanan->id . '-' . time();
        $pesanan->order_id = $orderId;
        $pesanan->save();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $pesanan->total_harga,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama_pelanggan,
                'email' => $pesanan->user->email ?? '',
            ],
        ];

        return Snap::createTransaction($params)->redirect_url;
    }
}
