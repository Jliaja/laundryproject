<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Harga;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesananController extends Controller
{
    // =========================
    // Ambil pesanan user login
    // =========================
    public function index(Request $request)
    {
        return Pesanan::where('user_id', $request->user()->id)->get();
    }

    // =========================
    // Simpan pesanan
    // =========================
   public function store(Request $request)
{
    $user = $request->user();
$now = Carbon::now('Asia/Jakarta');

    if ($now->format('H:i') > '16:00') {
        return response()->json([
            'message' => 'Pemesanan hari ini ditutup. Pesanan setelah jam 16:00 otomatis dibatalkan.'
        ], 403);
    }
    // ❌ Cek pesanan aktif
    $cek = Pesanan::where('user_id', $user->id)
        ->whereIn('status', ['menunggu', 'diproses', 'pending'])
        ->exists();

    if ($cek) {
        return response()->json([
            'message' => 'Masih ada pesanan aktif'
        ], 403);
    }

    // ✅ VALIDASI (BERSIH)
    $validated = $request->validate([
        'layanan'    => 'required|string',
        'tanggal'    => 'required|date',
        'voucher_id' => 'nullable|exists:vouchers,id',
    ]);

    $totalHarga = 0;
    $diskon = 0;

    // ================= VOUCHER =================
    if (!empty($validated['voucher_id'])) {
        $voucher = Voucher::find($validated['voucher_id']);

        if (!$voucher || $voucher->stok <= 0) {
            return response()->json([
                'message' => 'Voucher sudah habis'
            ], 400);
        }

        $diskon = $voucher->tipe === 'persen'
            ? $totalHarga * ($voucher->nilai / 100)
            : $voucher->nilai;

        $voucher->decrement('stok');
        $voucher->increment('terpakai');
    }

    // ================= SIMPAN =================
    $pesanan = Pesanan::create([
        'user_id'     => $user->id,
        'nama_pelanggan'    => $user->username,
        'address'     => $user->address,
        'layanan'     => $validated['layanan'],
        'jumlah'      => 0,
        'tanggal'     => $validated['tanggal'],
        'status'      => 'pending',
        'total_harga' => $totalHarga,
        'voucher_id'  => $validated['voucher_id'] ?? null,
        'diskon'      => $diskon,
        'total_akhir' => max($totalHarga - $diskon, 0),
    ]);

    return response()->json([
        'message' => 'Pesanan berhasil dibuat',
        'data' => $pesanan
    ], 201);
}


    // =========================
    // Cancel pesanan
    // =========================
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

    // =========================
    // Apply voucher
    // =========================
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'kode' => 'required|string'
        ]);

        $voucher = Voucher::where('kode', $request->kode)
            ->where('stok', '>', 0)
            ->whereDate('masa_berlaku', '>=', now())
            ->first();

        if (!$voucher) {
            return response()->json([
                'message' => 'Voucher tidak valid'
            ], 400);
        }

        return response()->json([
            'voucher_id' => $voucher->id,
            'kode'       => $voucher->kode,
            'tipe'       => $voucher->tipe,
            'nilai'      => $voucher->nilai
        ]);
    }
}
