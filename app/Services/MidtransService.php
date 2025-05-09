<?php

namespace App\Services;

use Xendit\Xendit;

class XenditService
{
    public function __construct()
    {
        Xendit::setApiKey(config('services.xendit.secret_key'));
    }

    public function createInvoice($pesanan)
    {
        // Kirim request ke Xendit untuk membuat invoice
        $response = Http::withBasicAuth(env('XENDIT_SECRET_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'order-' . $pesanan->id,
                'payer_email' => 'test@email.com', // Ganti dengan email pengguna yang sesuai
                'description' => 'Pembayaran Laundry #' . $pesanan->id,
                'amount' => $pesanan->total_harga,
            ]);

        return $response->json();
    }
}
