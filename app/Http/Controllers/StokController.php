<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\StokLog;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // ===============================
    // HALAMAN STOK + GRAFIK
    // ===============================
    public function index()
    {
        $stok = StokBarang::orderBy('nama_barang')->get();

        // data grafik stok keluar
        $labels = StokLog::where('tipe','keluar')
            ->selectRaw('DATE(created_at) as tanggal')
            ->groupBy('tanggal')
            ->pluck('tanggal');

        $data = StokLog::where('tipe','keluar')
            ->selectRaw('SUM(jumlah) as total')
            ->groupByRaw('DATE(created_at)')
            ->pluck('total');

        return view('admin.stok', compact('stok','labels','data'));
    }

    // ===============================
    // TAMBAH STOK BARANG
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'satuan' => 'required',
        ]);

        StokBarang::create($request->all());

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

    // ===============================
    // UPDATE STOK
    // ===============================
    public function update(Request $request, $id)
    {
        $stok = StokBarang::findOrFail($id);
        $stok->update($request->all());

        return back()->with('success', 'Stok berhasil diupdate');
    }

    // ===============================
    // HAPUS STOK
    // ===============================
    public function destroy($id)
    {
        StokBarang::findOrFail($id)->delete();
        return back()->with('success', 'Stok dihapus');
    }

    // ===============================
    // RESTOK
    // ===============================
    public function restok(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $stok = StokBarang::findOrFail($id);
        $stok->increment('stok', $request->jumlah);

        StokLog::create([
            'stok_barang_id' => $stok->id,
            'tipe' => 'masuk',
            'jumlah' => $request->jumlah,
            'keterangan' => 'Restok manual'
        ]);

        return back()->with('success','Stok berhasil direstok');
    }

    // ===============================
    // LOG STOK
    // ===============================
    public function log()
    {
        $logs = StokLog::with('stok')
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.stok-log', compact('logs'));
    }
}
