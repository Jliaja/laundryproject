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

    public function daftarpesanan()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)->get();
        return view('user.daftarpesanan', compact('pesanan'));
    }

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

    public function bayar($id, MidtransService $midtrans)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pembayaran === 'Lunas') {
            return redirect()->route('user.daftarpesanan')->with('error', 'Pesanan sudah dibayar.');
        }

        $paymentUrl = $midtrans->createPayment($pesanan);

        return redirect($paymentUrl);
    }

    public function showPilihPengambilan($pesanan_id)
    {
        $pesanan = Pesanan::findOrFail($pesanan_id);
        $user = Auth::user();
        $address = $user->address;

        return view('user.pilihpengambilan', compact('pesanan', 'address'));
    }

    public function submitPilihPengambilan(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'metode' => 'required|in:antar,ambil',
        ]);

        $pesanan = Pesanan::find($request->pesanan_id);
        $pesanan->metode_pengambilan = $request->metode;
        $pesanan->save();

        $message = $pesanan->metode_pengambilan === 'ambil'
            ? 'Silahkan ambil pesanan laundry kamu. Terima kasih.'
            : 'Pesanan akan diantarkan hari ini. Terima kasih.';

        return redirect()->route('user.pilihpengambilan', ['pesanan_id' => $pesanan->id])->with('success', $message);
    }
}
