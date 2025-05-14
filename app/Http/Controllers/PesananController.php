<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;

class PesananController extends Controller
{
    public function create()
    {
        return view('user.buatpesanan');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $request->validate([
            'layanan' => 'required|string',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ]);

        $hargaPerKg = [
            'Cuci Kering' => 5000,
            'Cuci Basah' => 6000,
            'Setrika' => 4000,
            'Lengkap (Cuci + Setrika)' => 8000
        ];

        $layanan = $request->input('layanan');
        $jumlah = $request->input('jumlah');
        $totalHarga = $hargaPerKg[$layanan] * $jumlah;

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'nama_pelanggan' => $user->username,
            'layanan' => $layanan,
            'jumlah' => $jumlah,
            'tanggal' => $request->tanggal,
            'total_harga' => $totalHarga,
            'status' => 'pending',
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('user.confirmpesanan', ['id' => $pesanan->id])
                         ->with('success', 'Pesanan berhasil dibuat, silakan lanjutkan pembayaran.');
    }

    public function confirm($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('user.confirmpesanan', compact('pesanan'));
    }

    public function bayar($id, MidtransService $midtrans)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pembayaran === 'Lunas') {
            return redirect()->route('user.daftarpesanan')->with('error', 'Pesanan sudah dibayar.');
        }

        $paymentUrl = $midtrans->createPayment($pesanan);
        return redirect($paymentUrl);
    }

    // Fungsi untuk menangani callback dari Midtrans
    public function midtransCallback(Request $request)
{
    // Inisialisasi Midtrans Notification
    $notification = new Notification();

    // Ambil status transaksi Midtrans
    $transactionStatus = $notification->transaction_status;
    $orderId = $notification->order_id;

    // Log status dan order_id untuk debugging
    \Log::info("Midtrans Callback received: Status = $transactionStatus, Order ID = $orderId");

    // Cari pesanan berdasarkan order_id
    $pesanan = Pesanan::where('order_id', $orderId)->first();

    if (!$pesanan) {
        \Log::error("Pesanan tidak ditemukan dengan Order ID: $orderId");
        return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
    }

    // Update status pembayaran berdasarkan status transaksi
    if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
        $pesanan->status_pembayaran = 'Lunas';
        $pesanan->status = 'proses';  // Ganti status pesanan menjadi proses
    } elseif ($transactionStatus == 'pending') {
        $pesanan->status_pembayaran = 'pending';
    } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel') {
        $pesanan->status_pembayaran = 'gagal';
    }

    // Simpan perubahan status
    $pesanan->save();

    // Log untuk memastikan status sudah terupdate
    \Log::info("Status Pesanan ID {$pesanan->id} diubah: Pembayaran = {$pesanan->status_pembayaran}, Status Pesanan = {$pesanan->status}");

    // Kembalikan response
    return response()->json(['status' => 'OK']);
}


    public function daftarpesanan()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)->get();
        return view('user.daftarpesanan', compact('pesanan'));
    }
}
