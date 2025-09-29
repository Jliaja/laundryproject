<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function riwayatKeuangan(Request $request)
    {
        $now = Carbon::now();

        // Ambil filter: bulan/tahun
        $filter = $request->get('filter', 'bulan'); // default bulan
        $bulan = $request->get('bulan', $now->format('m'));
        $tahun = $request->get('tahun', $now->year);

        // Query data transaksi sesuai filter
        $query = Pesanan::query()
            ->where('status', 'selesai')
            ->where('status_pembayaran', 'selesai');

        if ($filter == 'bulan') {
            $query->whereYear('created_at', $tahun)
                  ->whereMonth('created_at', $bulan);
        } else {
            $query->whereYear('created_at', $tahun);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Statistik utama (selalu bulan sekarang dan tahun sekarang)
        $ordersThisMonth = Pesanan::whereMonth('created_at', $now->month)
                                  ->whereYear('created_at', $now->year)
                                  ->where('status', 'selesai')
                                  ->where('status_pembayaran', 'selesai')
                                  ->count();

        $incomeThisMonth = Pesanan::whereMonth('created_at', $now->month)
                                  ->whereYear('created_at', $now->year)
                                  ->where('status', 'selesai')
                                  ->where('status_pembayaran', 'selesai')
                                  ->sum('total_harga');

        $incomeThisYear = Pesanan::whereYear('created_at', $now->year)
                                 ->where('status', 'selesai')
                                 ->where('status_pembayaran', 'selesai')
                                 ->sum('total_harga');

        // Total pemasukan filter
        $totalPemasukan = $transactions->sum('total_harga');

        // Data chart harian untuk bulan berjalan
        $chartLabels = [];
        $ordersData = [];
        $incomeData = [];

        // Jika filter bulan, buat chart harian bulan itu, jika filter tahun, buat chart bulanan tahun itu
        if ($filter == 'bulan') {
            $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($tahun, $bulan, $day);
                $chartLabels[] = $date->format('d');

                $ordersData[] = Pesanan::whereDate('created_at', $date)
                                       ->where('status', 'selesai')
                                       ->where('status_pembayaran', 'selesai')
                                       ->count();

                $incomeData[] = Pesanan::whereDate('created_at', $date)
                                       ->where('status', 'selesai')
                                       ->where('status_pembayaran', 'selesai')
                                       ->sum('total_harga');
            }
        } else {
            // Filter tahun - buat chart bulanan
            for ($month = 1; $month <= 12; $month++) {
                $chartLabels[] = Carbon::create($tahun, $month, 1)->format('F');

                $ordersData[] = Pesanan::whereYear('created_at', $tahun)
                                       ->whereMonth('created_at', $month)
                                       ->where('status', 'selesai')
                                       ->where('status_pembayaran', 'selesai')
                                       ->count();

                $incomeData[] = Pesanan::whereYear('created_at', $tahun)
                                       ->whereMonth('created_at', $month)
                                       ->where('status', 'selesai')
                                       ->where('status_pembayaran', 'selesai')
                                       ->sum('total_harga');
            }
        }

        return view('admin.keuangan', compact(
            'filter',
            'bulan',
            'tahun',
            'transactions',
            'ordersThisMonth',
            'incomeThisMonth',
            'incomeThisYear',
            'totalPemasukan',
            'chartLabels',
            'ordersData',
            'incomeData'
        ));
    }
}
