<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\VerifController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MidtransController;

/*
|--------------------------------------------------------------------------
| Route Public - Tanpa Login
|--------------------------------------------------------------------------
*/

// Halaman Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Route::post('/midtrans/callback', [MidtransController::class, 'callback']);



// Registrasi Pengguna Baru
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// 1. Input Email
Route::get('/lupa-password', [VerifController::class, 'formEmail'])->name('kirimemail');
Route::post('/kirim-kode', [VerifController::class, 'kirimKode'])->name('verifikasi.kirim.kode');

// 2. Verifikasi Kode OTP
Route::get('/verifikasi', [VerifController::class, 'formKode'])->name('verifikasi');
Route::post('/verifikasi', [VerifController::class, 'verifikasiKode'])->name('verifikasi.submit');

// 3. Reset Password
Route::get('/resetpassword', [VerifController::class, 'formResetPassword'])->name('resetpassword');
Route::post('/resetpassword', [VerifController::class, 'resetPassword'])->name('password.reset');

/*
|--------------------------------------------------------------------------
| Route User - Hanya Bisa Diakses Setelah Login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    /*
    |--------------------------------------------
    | Pesanan
    |--------------------------------------------
    */
    Route::get('/buatpesanan', [PesananController::class, 'create'])->name('user.buatpesanan');             // Form buat pesanan
    Route::post('/buatpesanan', [PesananController::class, 'store'])->name('user.storepesanan');            // Simpan pesanan
    Route::get('/daftarpesanan', [PesananController::class, 'daftarpesanan'])->name('user.daftarpesanan');  // Lihat daftar pesanan
    Route::get('/confirmpesanan/{id}', [PesananController::class, 'confirm'])->name('user.confirmpesanan'); // Konfirmasi pesanan

    // Pengambilan Pesanan
    Route::get('/pilihpengambilan/{pesanan_id}', [PesananController::class, 'showPilihPengambilan'])->name('user.pilihpengambilan');
    Route::post('/pilihpengambilan', [PesananController::class, 'submitPilihPengambilan'])->name('user.pilihpengambilan.submit');

    // Pembayaran
    Route::get('/bayar/{id}', [PesananController::class, 'bayar'])->name('user.bayar');           // Halaman bayar
    Route::post('/bayar/{id}', [PesananController::class, 'prosesBayar'])->name('user.bayar.submit'); // Proses bayar

    /*
    |--------------------------------------------
    | Profil User
    |--------------------------------------------
    */
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');         // Lihat profil
    Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit'); // Edit profil
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');  // Simpan perubahan profil
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
    Route::get('/kelola', [AdminController::class, 'kelolaPesanan'])->name('kelola');                  // Lihat semua pesanan
    Route::put('/pesanan/update/{id}', [PesananController::class, 'update'])->name('pesanan.update'); // Update status pesanan

    // Riwayat Keuangan
    Route::get('/keuangan', [KeuanganController::class, 'riwayatKeuangan'])->name('keuangan');
});

/*
|--------------------------------------------------------------------------
| Fallback - Redirect jika route tidak ditemukan
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect('/login')->with('error');
});
