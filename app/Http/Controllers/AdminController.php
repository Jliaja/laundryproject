<?php
namespace App\Http\Controllers;

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
        // Ambil data pesanan dari model (misalnya: Order model)
        // $orders = Order::all();
        return view('admin.kelola');  // Pastikan view kelola ada di resources/views/admin/kelola.blade.php
    }

    // Riwayat Keuangan
    public function riwayatKeuangan()
    {
        // Ambil data transaksi keuangan dari model (misalnya: Transaction model)
        // $transactions = Transaction::all();
        return view('admin.transaksi');  // Pastikan view transaksi ada di resources/views/admin/transaksi.blade.php
    }
}
