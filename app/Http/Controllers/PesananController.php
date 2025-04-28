<?php

namespace App\Http\Controllers;

use App\Models\Pesanan; // Pastikan sudah import model Pesanan
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
            'status' => 'pending',
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
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pesanan user yang sedang login
        $pesanan = Pesanan::where('user_id', Auth::id())  // Menggunakan model Pesanan
                          ->orderBy('created_at', 'desc')  // Urutkan berdasarkan waktu pesanan
                          ->get();

        return view('user.daftarpesanan', compact('pesanan'));
    }

    /**
     * Menampilkan riwayat pesanan user.
     */
    public function history()
    {
        // Ambil id user yang sedang login
        $userId = Auth::id();
        $pesanans = Pesanan::where('user_id', $userId)
                           ->orderBy('tanggal', 'desc')
                           ->get();
        
        return view('user.historypesanan', compact('pesanans'));
    }
}
