<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Notification;
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
        Log::info('Midtrans Callback Payload: ' . json_encode($request->all()));

        try {
            $notif = new Notification();

            $orderId = $notif->order_id;
            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status;

            $pesanan = Pesanan::where('order_id', $orderId)->first();

            if (!$pesanan) {
                Log::error("Pesanan tidak ditemukan dengan order_id: $orderId");
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            Log::info("Midtrans Callback - OrderID: $orderId, Status: $transactionStatus, Fraud: $fraudStatus");

            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'challenge') {
                        $pesanan->status_pembayaran = 'pending';
                        $pesanan->status = 'pending';
                    } elseif ($fraudStatus == 'accept') {
                        $pesanan->status_pembayaran = 'selesai';
                        $pesanan->status = 'selesai';
                    }
                    break;

                case 'settlement':
                    $pesanan->status_pembayaran = 'selesai';
                    $pesanan->status = 'selesai';
                    break;

                case 'pending':
                    $pesanan->status_pembayaran = 'pending';
                    $pesanan->status = 'pending';
                    break;

                case 'deny':
                case 'cancel':
                case 'expire':
                    $pesanan->status_pembayaran = 'gagal';
                    $pesanan->status = 'batal';
                    break;

                default:
                    Log::warning("Status transaksi tidak dikenali: $transactionStatus");
                    break;
            }

            $pesanan->save();

            return response()->json(['message' => 'Callback berhasil diproses']);

        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }
}
