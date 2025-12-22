<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;

class HargaController extends Controller
{
    // Tampilkan semua harga
    public function harga()
    {
        $hargas = Harga::all();
        return view('admin.harga', compact('hargas'));
    }

    // Form tambah harga
    public function create()
    {
        return view('admin.harga.create');
    }

    // Simpan harga baru
    public function store(Request $request)
    {
        $request->validate([
            'layanan' => 'required|string|max:255',
            'hargaPerKg' => 'required|numeric|min:0',
        ]);

        Harga::create([
            'layanan' => $request->layanan,
            'hargaPerKg' => $request->hargaPerKg,
        ]);

        return redirect()->route('admin.harga')->with('success', 'Harga berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $harga = Harga::findOrFail($id);
        return view('admin.harga.edit', compact('harga'));
    }

    // Update harga
    public function update(Request $request, $id)
{
    $request->validate([
        'hargaPerKg' => 'required|numeric|min:0',
    ]);

    $harga = Harga::findOrFail($id);
    $harga->update([
        'hargaPerKg' => $request->hargaPerKg,
    ]);

    return redirect()->route('admin.harga')->with('success', 'Harga berhasil diperbarui.');
}


    // Hapus harga
    public function destroy($id)
    {
        Harga::findOrFail($id)->delete();
        return redirect()->route('admin.harga')->with('success', 'Harga berhasil dihapus.');
    }
}
