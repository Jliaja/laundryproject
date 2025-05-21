<?php 

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Harga; 
use Illuminate\Http\Request;

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
        $pesanans = Pesanan::all();
        return view('admin.kelola', compact('pesanans'));
    }

    // Update pesanan dengan hitung total harga berdasarkan harga layanan
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->status = $request->input('status');
        $pesanan->jumlah = $request->input('jumlah');

        // Ambil harga per Kg dari tabel Harga berdasarkan layanan di pesanan
        $hargaRecord = Harga::where('layanan', $pesanan->layanan)->first();

        if ($hargaRecord && $pesanan->jumlah) {
            $pesanan->total_harga = $pesanan->jumlah * $hargaRecord->hargaPerKg;
        } else {
            // Jika harga tidak ditemukan, set total_harga jadi 0 atau null
            $pesanan->total_harga = 0;
        }

        $pesanan->save();

        return redirect()->back()->with('success', 'Pesanan berhasil diperbarui');
    }

    // Kelola Harga Pesanan
    public function kelolaHargaPesanan()
    {
        $hargas = Harga::all();
        return view('admin.harga', compact('hargas'));
    }
}
