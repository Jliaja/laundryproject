<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
}
