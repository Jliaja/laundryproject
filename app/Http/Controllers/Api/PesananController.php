<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Harga;
use App\Models\Voucher;
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
        'voucher_id' => 'nullable|exists:vouchers,id',
    ]);

    // Harga default per layanan
    $hargaRecord = Harga::where('layanan', $validated['layanan'])->first();
    $totalHarga = 0; // user belum input jumlah cucian

    $diskon = 0;

    // Hitung diskon kalau voucher dipilih
    if (!empty($validated['voucher_id'])) {
    $voucher = Voucher::find($validated['voucher_id']);

    if ($voucher) {

        // Cek apakah stok tersedia
        if ($voucher->stok <= 0) {
            return response()->json([
                'message' => 'Voucher sudah habis'
            ], 400);
        }

        // Hitung diskon
        if ($voucher->tipe == 'persen') {
            $diskon = $totalHarga * ($voucher->nilai / 100);
        } else {
            $diskon = $voucher->nilai;
        }

        // Kurangi stok
        $voucher->decrement('stok', 1);

        // Tambah terpakai
        $voucher->increment('terpakai', 1);
    }
}

    // Simpan pesanan
    $pesanan = Pesanan::create([
        'user_id' => $request->user()->id,
        'nama_pelanggan' => $validated['nama_pelanggan'],
        'layanan' => $validated['layanan'],
        'jumlah' => 0,
        'tanggal' => $validated['tanggal'],
        'status' => 'pending',
        'address' => $validated['address'],
        'total_harga' => $totalHarga,
        'voucher_id' => $validated['voucher_id'] ?? null,
        'diskon' => $diskon,
        'total_akhir' => max($totalHarga - $diskon, 0), // jangan negatif
    ]);

    return response()->json([
        'message' => 'Pesanan berhasil dibuat',
        'data' => $pesanan,
    ], 201);
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
    public function applyVoucher(Request $request)
{
    $kode = $request->kode;

    $voucher = Voucher::where('kode', $kode)
        ->where('stok', '>', 0)
        ->whereDate('masa_berlaku', '>=', now())
        ->first();

    if (!$voucher) {
        return response()->json(['message' => 'Voucher tidak valid'], 400);
    }

    return response()->json([
        'voucher_id' => $voucher->id,
        'kode'       => $voucher->kode,
        'tipe'       => $voucher->tipe,
        'nilai'      => $voucher->nilai
    ]);
}

}
