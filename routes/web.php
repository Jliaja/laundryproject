<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ForgetPassController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CekLogin;

/*
|--------------------------------------------------------------------------
| Route Public - Tanpa Login
|--------------------------------------------------------------------------
*/

// Halaman Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registrasi Pengguna Baru
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Lupa Password
// 1. Input Email
Route::get('/lupa-password', [ForgetPassController::class, 'formEmail'])->name('kirimemail');
Route::post('/kirim-kode', [ForgetPassController::class, 'kirimKode'])->name('verifikasi.kirim.kode');
// 2. Verifikasi Kode OTP
Route::get('/verifikasi', [ForgetPassController::class, 'formKode'])->name('verifikasi');
Route::post('/verifikasi', [ForgetPassController::class, 'verifikasiKode'])->name('verifikasi.kode');
// 3. Reset Password
Route::get('/reset-password', [ForgetPassController::class, 'formResetPassword'])->name('password.reset.form');
Route::post('/reset-password', [ForgetPassController::class, 'resetPassword'])->name('password.reset');

// Midtrans Payment
Route::post('/payment/create-transaction', [PaymentController::class, 'createTransaction']);
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| Route User - Hanya Bisa Diakses Setelah Login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard User
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Pesanan
    Route::get('/buatpesanan', [PesananController::class, 'create'])->name('user.buatpesanan');
    Route::post('/buatpesanan', [PesananController::class, 'store'])->name('user.storepesanan');
    Route::get('/daftarpesanan', [PesananController::class, 'daftarpesanan'])->name('user.daftarpesanan');
    Route::get('/confirmpesanan/{id}', [PesananController::class, 'confirm'])->name('user.confirmpesanan');

    // Pengambilan Pesanan
    Route::get('/pilihpengambilan/{pesanan_id}', [PesananController::class, 'showPilihPengambilan'])->name('user.pilihpengambilan');
    Route::post('/pilihpengambilan', [PesananController::class, 'submitPilihPengambilan'])->name('user.pilihpengambilan.submit');

    // Pembayaran
    Route::get('/bayar/{id}', [PesananController::class, 'bayar'])->name('user.bayar');
    Route::post('/bayar/{id}', [PesananController::class, 'prosesBayar'])->name('user.bayar.submit');

    // Profil Pengguna
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

/*
|--------------------------------------------------------------------------
| Route Admin - Role: admin (Proteksi dengan Middleware ceklogin:admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'ceklogin:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen Pesanan
    Route::get('/kelola', [AdminController::class, 'kelolaPesanan'])->name('kelola');
    Route::put('/pesanan/update/{id}', [PesananController::class, 'update'])->name('pesanan.update');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');

    // Riwayat Keuangan
    Route::get('/keuangan', [KeuanganController::class, 'riwayatKeuangan'])->name('keuangan');

    // Harga Layanan
    Route::get('/harga', [HargaController::class, 'harga'])->name('harga');
    Route::get('/harga/create', [HargaController::class, 'create'])->name('harga.create');
    Route::post('/harga', [HargaController::class, 'store'])->name('harga.store');
    Route::get('/harga/{id}/edit', [HargaController::class, 'edit'])->name('harga.edit');
    Route::put('/harga/{id}', [HargaController::class, 'update'])->name('harga.update');
    Route::delete('/harga/{id}', [HargaController::class, 'destroy'])->name('harga.destroy');
});

/*
|--------------------------------------------------------------------------
| Fallback - Redirect jika route tidak ditemukan
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect('/login')->with('error');
});
