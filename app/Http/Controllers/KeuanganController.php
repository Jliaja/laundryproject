<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::where('status', 'selesai'); // Hanya transaksi selesai

        if ($request->filter == 'bulan' && $request->filled(['bulan', 'tahun_bulan'])) {
            $query->whereMonth('tanggal', $request->bulan)
                  ->whereYear('tanggal', $request->tahun_bulan);
        } elseif ($request->filter == 'tahun' && $request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $transactions = $query->get();
        $totalPemasukan = $transactions->sum('total_harga');

        return view('admin.keuangan', compact('transactions', 'totalPemasukan'));
    }

    public function riwayatKeuangan(Request $request)
    {
        $filter = $request->input('filter', 'bulan'); // Default ke bulanan
        $tanggal = $request->input('tanggal');

        $query = Pesanan::where('status', 'selesai');

        if ($filter && $tanggal) {
            $tanggalParsed = Carbon::parse($tanggal);

            if ($filter == 'bulan') {
                $query->whereMonth('tanggal', $tanggalParsed->month)
                      ->whereYear('tanggal', $tanggalParsed->year);
            } elseif ($filter == 'minggu') {
                $query->whereBetween('tanggal', [
                    $tanggalParsed->startOfWeek(),
                    $tanggalParsed->endOfWeek(),
                ]);
            } elseif ($filter == 'tahun') {
                $query->whereYear('tanggal', $tanggalParsed->year);
            }
        }

        $transactions = $query->get();
        $totalPemasukan = $transactions->sum('total_harga');

        return view('admin.keuangan', compact('transactions', 'totalPemasukan', 'filter', 'tanggal'));
    }
}
