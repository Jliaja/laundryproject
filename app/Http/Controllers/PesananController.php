<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;
use Midtrans\Notification;

class PesananController extends Controller
{
    // Form pemesanan
    public function create()
    {
        return view('user.buatpesanan');
    }

    // Simpan pesanan baru
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

        $orderId = 'ORDER-' . time() . '-' . rand(1000, 9999); // Order ID unik untuk Midtrans

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'nama_pelanggan' => $user->username,
            'layanan' => $layanan,
            'jumlah' => $jumlah,
            'tanggal' => $request->tanggal,
            'total_harga' => $totalHarga,
            'status' => 'pending', // status proses laundry: pending → selesai
            'status_pembayaran' => 'pending', // status pembayaran: pending → selesai → gagal
            'order_id' => $orderId
        ]);

        return redirect()->route('user.confirmpesanan', ['id' => $pesanan->id])
                        ->with('success', 'Pesanan berhasil dibuat, silakan lanjutkan pembayaran.');
    }

    // Tampilkan halaman konfirmasi pesanan
    public function confirm($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('user.confirmpesanan', compact('pesanan'));
    }

    // Proses pembayaran via Midtrans
    public function bayar($id, MidtransService $midtrans)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pembayaran === 'selesai') {
            return redirect()->route('user.daftarpesanan')->with('error', 'Pesanan sudah dibayar.');
        }

        $paymentUrl = $midtrans->createPayment($pesanan);
        return redirect($paymentUrl);
    }

    // Tampilkan daftar semua pesanan user
    public function daftarpesanan()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)->get();
        return view('user.daftarpesanan', compact('pesanan'));
    }

    // Form pilih metode pengambilan
// Tampilkan halaman pemilihan metode pengambilan
public function showPilihPengambilan($pesanan_id)
{
    $pesanan = Pesanan::findOrFail($pesanan_id);

    // Jika user yang login bukan pemilik pesanan, tolak akses
    if ($pesanan->user_id !== Auth::id()) {
        return redirect()->route('user.daftarpesanan')->with('error', 'Akses ditolak.');
    }

    // Ambil alamat dari user jika ada
    $address = Auth::user()->alamat ?? '';

    return view('user.pilihpengambilan', compact('pesanan', 'address'));
}


// Simpan pilihan metode pengambilan
public function submitPilihPengambilan(Request $request)
{
    $request->validate([
        'pesanan_id' => 'required|exists:pesanans,id',
        'metode' => 'required|in:antar,ambil',
        'alamat' => 'nullable|string|max:255',
    ]);

    $pesanan = Pesanan::findOrFail($request->pesanan_id);

    if ($pesanan->user_id !== Auth::id()) {
        return redirect()->route('user.daftarpesanan')->with('error', 'Akses ditolak.');
    }

    $pesanan->metode_pengambilan = $request->metode;
    if ($request->metode === 'antar') {
        $pesanan->alamat_pengambilan = $request->alamat;
        $pesanan->total_harga += 5000; // Tambah ongkir 5000
    }
    $pesanan->save();

    return redirect()->route('user.pilihpengambilan', $pesanan->id)->with('success', 'Metode pengambilan berhasil disimpan.');
}


}
