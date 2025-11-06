<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Harga;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Ambil semua pesanan user login
    public function index(Request $request)
    {
        $user = $request->user();
        $pesanan = Pesanan::where('user_id', $user->id)->get();

        return response()->json($pesanan);
    }

    // Simpan pesanan baru (mobile)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'nama_pelanggan' => 'required|string',
            'layanan' => 'required|string',
            'jumlah' => 'required|integer|min:0',
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Ambil harga per layanan (kalau ada di tabel Harga)
        $hargaRecord = Harga::where('layanan', $validated['layanan'])->first();
        $hargaPerKg = $hargaRecord ? $hargaRecord->hargaPerKg : 0;

        // Hitung total harga (kalau jumlah > 0)
        $totalHarga = $validated['jumlah'] > 0 ? $validated['jumlah'] * $hargaPerKg : 0;

        $pesanan = Pesanan::create([
            'user_id' => $validated['user_id'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'layanan' => $validated['layanan'],
            'jumlah' => $validated['jumlah'],
            'tanggal' => $validated['tanggal'],
            'status' => $validated['status'],
            'alamat' => $validated['alamat'],
            'total_harga' => $totalHarga,
        ]);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $pesanan,
        ], 201);
    }

    // Detail pesanan user tertentu
    public function show(Request $request, $id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($pesanan);
    }

    // Batalkan pesanan
    public function cancel(Request $request, $id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $pesanan->update(['status' => 'dibatalkan']);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan dibatalkan',
            'pesanan' => $pesanan
        ]);
    }
}
