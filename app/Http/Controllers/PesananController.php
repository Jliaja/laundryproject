<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\XenditService;

class PesananController extends Controller
{
    /**
     * Tampilkan form buat pesanan.
     */
    public function create()
    {
        return view('user.buatpesanan');
    }

    /**
     * Simpan pesanan baru ke database.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Validasi input
        $request->validate([
            'layanan' => 'required|string',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ]);

        // Daftar harga per kg
        $hargaPerKg = [
            'Cuci Kering' => 5000,
            'Cuci Basah' => 6000,
            'Setrika' => 4000,
            'Lengkap (Cuci + Setrika)' => 8000
        ];

        // Ambil layanan dan jumlah, hitung total harga
        $layanan = $request->input('layanan');
        $jumlah = $request->input('jumlah');
        $totalHarga = $hargaPerKg[$layanan] * $jumlah;

        // Simpan pesanan ke database
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'nama_pelanggan' => $user->username,
            'layanan' => $layanan,
            'jumlah' => $jumlah,
            'tanggal' => $request->tanggal,
            'total_harga' => $totalHarga,
            'status' => 'pending',
            'status_pembayaran' => 'Lunas',
        ]);

        // Redirect ke halaman konfirmasi pesanan
        return redirect()->route('user.confirmpesanan', ['id' => $pesanan->id])
                         ->with('success', 'Pesanan berhasil dibuat dan dibayar!');
    }

    /**
     * Tampilkan halaman konfirmasi pesanan.
     */
    public function confirm($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('user.confirmpesanan', compact('pesanan'));
    }

    /**
     * Tampilkan daftar pesanan milik user yang login.
     */
    public function daftarpesanan()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
        $pesanan = Pesanan::where('user_id', $user->id)->get(); // Ambil pesanan milik user
        return view('user.daftarpesanan', compact('pesanan'));
    }

    /**
     * Ubah status pesanan oleh admin.
     */
    public function ubahStatus($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Hanya admin yang bisa mengubah status pesanan.');
        }

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'proses';  // Set status menjadi proses
        $pesanan->save();

        return redirect()->route('admin.kelola')->with('success', 'Status pesanan berhasil diubah!');
    }

    /**
     * Update status pesanan oleh admin.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,proses,selesai,batal',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('admin.kelola')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Proses pembayaran melalui Xendit.
     */
    public function bayar($id, XenditService $xendit)
    {
        // Cari pesanan berdasarkan ID
        $order = Pesanan::findOrFail($id);

        // Pastikan pesanan belum dibayar
        if ($order->status_pembayaran !== 'Lunas') {
            return redirect()->route('user.daftarpesanan')
                             ->with('error', 'Pesanan sudah dibayar atau sedang diproses.');
        }

        // Membuat invoice melalui Xendit
        $invoice = $xendit->createInvoice($order);

        // Simpan URL invoice ke database dan set status pembayaran menjadi pending
        $order->invoice_url = $invoice['invoice_url'];  // Simpan URL untuk ke halaman Xendit
        $order->status_pembayaran = 'pending';  // Set status pembayaran jadi pending
        $order->save();

        // Redirect ke URL invoice untuk pembayaran
        return redirect($invoice['invoice_url']);
    }

    /**
     * Tampilkan form pemilihan metode pengambilan pesanan.
     */
    public function showPilihPengambilan($pesanan_id)
    {
        // Mencari pesanan berdasarkan ID
        $pesanan = Pesanan::findOrFail($pesanan_id);

        // Mengirim data pesanan ke view
        return view('user.pilihpengambilan', compact('pesanan'));
    }

    /**
     * Simpan pilihan metode pengambilan pesanan.
     */
    public function submitPilihPengambilan(Request $request)
    {
        // Validasi input
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'metode' => 'required|in:antar_jemput,datang_sendiri',
        ]);

        // Cari pesanan berdasarkan ID
        $pesanan = Pesanan::find($request->pesanan_id);

        // Simpan pilihan metode pengambilan
        $pesanan->metode_pengambilan = $request->metode;
        $pesanan->save();

        // Redirect dengan pesan sukses
        return redirect()->route('user.dashboard')->with('success', 'Metode pengambilan berhasil dipilih.');
    }
}
