<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Simpan data pesanan ke database.
     */
    public function store(Request $request)
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Validasi data input
        $request->validate([
            'layanan' => 'required|string',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        // Simpan pesanan menggunakan model Pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'nama_pelanggan' => $user->username,
            'layanan' => $request->layanan,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'status' => 'pending',  // Status default adalah 'pending'
        ]);

        // Redirect ke halaman konfirmasi
        return redirect()->route('user.confirmpesanan', ['id' => $pesanan->id])
                         ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Menampilkan detail konfirmasi pesanan.
     */
    public function confirm($id)
    {
        // Ambil data pesanan menggunakan model Pesanan
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        return view('user.confirmpesanan', compact('pesanan'));
    }

    /**
     * Menampilkan daftar pesanan user.
     */
    public function daftarpesanan()
{
    $userId = Auth::id(); // Ambil ID user yang login
    // Ambil data pesanan untuk user yang login
    $pesanan = Pesanan::where('user_id', $userId)->get();
    return view('user.daftarpesanan', compact('pesanan'));
}

    /**
     * Mengubah status pesanan oleh admin.
     */
    public function ubahStatus($id)
    {
        // Cek apakah user adalah admin
        if (!Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('login')->with('error', 'Hanya admin yang bisa mengubah status pesanan.');
        }

        // Cari pesanan berdasarkan ID
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return redirect()->route('admin.kelola')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Ubah status pesanan
        $pesanan->status = 'proses'; // Atau status lain sesuai kebutuhan
        $pesanan->save();

        return redirect()->route('admin.kelola')->with('success', 'Status pesanan berhasil diubah!');
    }

    /**
     * Mengupdate status pesanan
     */
    public function update(Request $request, $id)
    {
        // Cari pesanan berdasarkan ID
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return redirect()->route('admin.kelola')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Validasi status yang dikirim
        $request->validate([
            'status' => 'required|string|in:pending,proses,selesai,batal', // Status yang valid
        ]);

        // Update status pesanan
        $pesanan->status = $request->status; // Mengambil status dari form
        $pesanan->save();

        // Redirect ke halaman kelola dengan pesan sukses
        return redirect()->route('admin.kelola')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
