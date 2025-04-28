<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\VerifController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekLogin;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});
// Route untuk login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk dashboard (hanya bisa diakses setelah login)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    
    // Ganti Password
    Route::get('/ganti-password', [UserController::class, 'gantiPasswordForm'])->name('user.password.form');
    Route::post('/ganti-password', [UserController::class, 'updatePassword'])->name('user.change-password');

    // Pesanan
    Route::get('/buatpesanan', [PesananController::class, 'create'])->name('user.buatpesanan');
    Route::post('/buatpesanan', [PesananController::class, 'store'])->name('user.storepesanan');
    Route::get('/daftarpesanan', [PesananController::class, 'daftarpesanan'])->name('user.daftarpesanan');
    Route::get('/confirmpesanan/{id}', [PesananController::class, 'confirm'])->name('user.confirmpesanan');
    Route::get('/riwayatpesanan', [PesananController::class, 'history'])->name('user.historypesanan');

    // Tampilkan profil pengguna
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    
    // Tampilkan halaman edit profil
    Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    
    // Proses pembaruan profil
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
     // Ganti Password (Jika diperlukan)
     Route::get('/user/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
     Route::post('/user/change-password', [UserController::class, 'changePassword'])->name('user.change-password.update');
});


// Route untuk register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// 1. Form input email (lupa password)
Route::get('/lupa-password', [VerifController::class, 'formEmail'])->name('kirimemail'); // Menampilkan form untuk input email
Route::post('/kirim-kode', [VerifController::class, 'kirimKode'])->name('verifikasi.kirim.kode'); // Mengirim kode OTP ke email

// 2. Verifikasi kode OTP
Route::get('/verifikasi', [VerifController::class, 'formKode'])->name('verifikasi'); // Menampilkan form input OTP
Route::post('/verifikasi', [VerifController::class, 'verifikasiKode'])->name('verifikasi.submit'); // Mengecek kecocokan kode OTP

// 3. Reset password
Route::get('/resetpassword', [VerifController::class, 'formResetPassword'])->name('resetpassword'); // Menampilkan form reset password
Route::post('/resetpassword', [VerifController::class, 'resetPassword'])->name('password.reset'); // Menyimpan password baru

// ADMIN
Route::middleware(['auth', 'ceklogin:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelola', [AdminController::class, 'kelolaPesanan'])->name('kelola');
    Route::get('/transaksi', [AdminController::class, 'riwayatKeuangan'])->name('transaksi');
});



