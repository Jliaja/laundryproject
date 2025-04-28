<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    // Menampilkan halaman riwayat transaksi user
    public function index()
    {
        $transaksi = DB::table('transaksi')
            ->where('id_user', Session::get('user.id')) // asumsikan login user disimpan di session
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('user.transaksi.history', compact('transaksi'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        return view('user.transaksi.buattransaksi');
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'metode' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        DB::table('transaksi')->insert([
            'id_user' => Session::get('user.id'),
            'jumlah' => $request->jumlah,
            'metode' => $request->metode,
            'tanggal' => $request->tanggal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('transaksi.history')->with('success', 'Transaksi berhasil ditambahkan.');
    }
}
