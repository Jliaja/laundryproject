<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Harga;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    // Kelola Pesanan
    public function kelolaPesanan()
{
    $pesanans = Pesanan::all(); // ambil data terbaru dari DB setiap akses halaman
    return view('admin.kelola', compact('pesanans'));
}


    // Update pesanan
    public function updateMassal(Request $request)
{
    $data = $request->input('pesanans', []);

    foreach ($data as $id => $values) {
        $pesanan = Pesanan::find($id);
        if (!$pesanan) continue;

        // Update status jika tersedia
        if (isset($values['status'])) {
            $pesanan->status = $values['status'];
        }

        // Update jumlah jika tersedia
        if (isset($values['jumlah'])) {
            $pesanan->jumlah = floatval($values['jumlah']);

            $hargaRecord = Harga::where('layanan', $pesanan->layanan)->first();
            if ($hargaRecord) {
                $pesanan->total_harga = $pesanan->jumlah * $hargaRecord->hargaPerKg;
            } else {
                $pesanan->total_harga = 0;
            }
        }

        $pesanan->save();
    }

    return redirect()->back()->with('success', 'Semua pesanan berhasil diperbarui.');
}


    // Kelola Harga
    public function kelolaHargaPesanan()
    
    {
        $hargas = Harga::all();
        return view('admin.harga', compact('hargas'));
    }
}
