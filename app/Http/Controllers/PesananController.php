<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananController extends Controller
{
    /**
     * Tampilkan form pemesanan.
     */
    public function create()
    {
        $hargas = Harga::all();
        return view('user.buatpesanan', compact('hargas'));
    }

    /**
     * Simpan pesanan baru dari user.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'layanan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $user = Auth::user();

        $orderId = 'ORDER-' . time() . '-' . rand(1000, 9999); // Order ID unik

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'nama_pelanggan' => $user->username,
            'layanan' => $request->layanan,
            'jumlah' => 0, // Diisi nanti oleh admin
            'tanggal' => $request->tanggal,
            'total_harga' => 0, // Diisi nanti oleh admin
            'status' => 'pending', // Status proses laundry
            'status_pembayaran' => 'pending', // Status pembayaran
            'order_id' => $orderId
        ]);

        return redirect()->route('user.confirmpesanan', ['id' => $pesanan->id])
                         ->with('success', 'Pesanan berhasil dibuat, silakan lanjutkan pembayaran.');
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
     * Proses pembayaran via Midtrans.
     */

    /**
     * Tampilkan daftar semua pesanan milik user.
     */
    public function daftarpesanan()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)->get();
        return view('user.daftarpesanan', compact('pesanan'));
    }

    /**
     * Tampilkan form pemilihan metode pengambilan (antar/ambil sendiri).
     */
    public function showPilihPengambilan($pesanan_id)
{
    $pesanan = Pesanan::findOrFail($pesanan_id);

    // Ambil data user yang sedang login
    $user = auth()->user();

    // Kirim data user ke view, termasuk alamatnya
    return view('user.pilihpengambilan', [
        'pesanan' => $pesanan,
        'user' => $user,
        'address' => $user->address ?? '',  // pakai alamat user, kalau kosong kasih string kosong
    ]);
}

    /**
     * Simpan pilihan metode pengambilan.
     */
    public function submitPilihPengambilan(Request $request)
{
    $request->validate([
        'pesanan_id' => 'required|exists:pesanans,id',
        'metode' => 'required|in:antar,ambil',
        'alamat' => $request->metode === 'antar' ? 'required|string|max:255' : 'nullable',
    ]);

    $pesanan = Pesanan::findOrFail($request->pesanan_id);
    $pesanan->metode_pengambilan = $request->metode;
    $pesanan->alamat_pengambilan = $request->alamat ?? null;
    $pesanan->save();

    return back()->with('success', 'Metode pengambilan berhasil disimpan.');
}
    public function update(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);

    // Update status jika ada input
    if ($request->has('status')) {
        $pesanan->status = $request->input('status');
    }

    // Update jumlah jika ada input
    if ($request->has('jumlah')) {
        $pesanan->jumlah = $request->input('jumlah');

        // Cek harga per Kg sesuai layanan
        $hargaRecord = Harga::where('layanan', $pesanan->layanan)->first();
        if ($hargaRecord) {
            $pesanan->total_harga = $pesanan->jumlah * $hargaRecord->hargaPerKg;
        } else {
            $pesanan->total_harga = 0; // Default jika harga tidak ditemukan
        }
    }

    $pesanan->save();

    return redirect()->back()->with('success', 'Pesanan berhasil diperbarui');
}

}
