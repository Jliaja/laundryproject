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
    public function riwayatKeuangan()
    {
        // Ambil data transaksi keuangan dari model (misalnya: Transaction model)
        // $transactions = Transaction::all();
        return view('admin.transaksi');  // Pastikan view transaksi ada di resources/views/admin/transaksi.blade.php
    }
}