<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Harga;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Ambil pesanan user login
    public function index(Request $request)
    {
        return Pesanan::where('user_id', $request->user()->id)->get();
    }

    // Simpan pesanan mobile TANPA jumlah & status
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string',
            'layanan' => 'required|string',
            'tanggal' => 'required|date',
            'address' => 'required|string',
        ]);

        // Harga default 0
        $totalHarga = 0;

        // Buat pesanan
        $pesanan = Pesanan::create([
            'user_id' => $request->user()->id,
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'layanan' => $validated['layanan'],
            'jumlah' => 0, // user tidak isi
            'tanggal' => $validated['tanggal'],
            'status' => 'pending', // default
            'address' => $validated['address'],
            'total_harga' => $totalHarga,
        ]);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $pesanan,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        return Pesanan::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();
    }

    public function cancel(Request $request, $id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $pesanan->update(['status' => 'dibatalkan']);

        return [
            'success' => true,
            'message' => 'Pesanan dibatalkan',
            'pesanan' => $pesanan
        ];
    }
}
