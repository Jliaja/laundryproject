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
     * Simpan pesanan baru ke database.
     */
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
            'status_pembayaran' => 'Lunas',
        ]);

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

        $pesanan = Pesanan::where('user_id', $user->id)->get(); // Ambil pesanan milik user tersebut

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
        $pesanan->status = 'proses';
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
}
