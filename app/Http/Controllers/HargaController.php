<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;

class HargaController extends Controller
{
    // Tampilkan semua harga
    public function harga()
    {
        $hargaList = Harga::all();
        return view('admin.harga', compact('hargaList'));
    }

    // Tampilkan form tambah harga
    public function create()
    {
        return view('admin.harga.create');
    }

    // Simpan harga baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'hargaPerKg

' => 'required|numeric|min:0',
        ]);

        Harga::create([
            'jenis_layanan' => $request->jenis_layanan,
            'hargaPerKg

' => $request->hargaPerKg

,
        ]);

        return redirect()->route('admin.harga')->with('success', 'Harga berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $harga = Harga::findOrFail($id);
        return view('admin.harga.edit', compact('harga'));
    }

    // Simpan perubahan harga
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'hargaPerKg

' => 'required|numeric|min:0',
        ]);

        $harga = Harga::findOrFail($id);
        $harga->update([
            'jenis_layanan' => $request->jenis_layanan,
            'hargaPerKg

' => $request->hargaPerKg

,
        ]);

        return redirect()->route('admin.harga.harga')->with('success', 'Harga berhasil diperbarui.');
    }

    // Hapus harga
    public function destroy($id)
    {
        $harga = Harga::findOrFail($id);
        $harga->delete();

        return redirect()->route('admin.harga')->with('success', 'Harga berhasil dihapus.');
    }
}
