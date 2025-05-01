<?php
namespace App\Http\Controllers;
use App\Models\Pesanan;

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
        // Ambil semua pesanan dari database
        $pesanans = Pesanan::all();  // Mengambil semua pesanan

        // Kirim data pesanan ke view
        return view('admin.kelola', compact('pesanans'));  // Mengirim variabel pesanans ke view
    }

    // Riwayat Keuangan
    public function riwayatKeuangan(Request $request)
{
    $filter = $request->input('filter', 'bulan'); // Default 'bulan' jika tidak ada filter
    $tanggal = $request->input('tanggal');

    // Query dasar untuk mengambil transaksi
    $query = Pesanan::where('status_pembayaran', 'Lunas'); // Hanya transaksi yang sudah lunas

    if ($filter && $tanggal) {
        if ($filter == 'bulan') {
            // Filter berdasarkan bulan
            $query->whereMonth('created_at', Carbon::parse($tanggal)->month)
                  ->whereYear('created_at', Carbon::parse($tanggal)->year);
        } elseif ($filter == 'minggu') {
            // Filter berdasarkan minggu
            $query->whereBetween('created_at', [
                Carbon::parse($tanggal)->startOfWeek(),
                Carbon::parse($tanggal)->endOfWeek(),
            ]);
        } elseif ($filter == 'tahun') {
            // Filter berdasarkan tahun
            $query->whereYear('created_at', Carbon::parse($tanggal)->year);
        }
    }

    // Ambil data transaksi yang sudah difilter
    $transactions = $query->get();

    // Kirim data ke view
    return view('admin.transaksi', compact('transactions'));
}

}