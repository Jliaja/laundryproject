<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ForgetPassController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\Api\PaymentController;      // versi web
use App\Http\Controllers\MidtransController;     // callback web
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN & REGISTER
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// LUPA PASSWORD
Route::get('/lupa-password', [ForgetPassController::class, 'formEmail'])->name('kirimemail');
Route::post('/kirim-kode', [ForgetPassController::class, 'kirimKode'])->name('verifikasi.kirim.kode');
Route::get('/verifikasi', [ForgetPassController::class, 'formKode'])->name('verifikasi');
Route::post('/verifikasi', [ForgetPassController::class, 'verifikasiKode'])->name('verifikasi.kode');
Route::get('/reset-password', [ForgetPassController::class, 'formResetPassword'])->name('password.reset.form');
Route::post('/reset-password', [ForgetPassController::class, 'resetPassword'])->name('password.reset');

// CALLBACK MIDTRANS UNTUK WEB
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// USER LOGIN
Route::middleware(['auth'])->group(function () {

    // DASHBOARD USER
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // PESANAN
    Route::get('/buatpesanan', [PesananController::class, 'create'])->name('user.buatpesanan');
    Route::post('/buatpesanan', [PesananController::class, 'store']);
    Route::get('/daftarpesanan', [PesananController::class, 'daftarpesanan'])->name('user.daftarpesanan');

    // PEMBAYARAN (WEB)
    Route::get('/pembayaran/{id}', [PaymentController::class, 'createTransaction'])->name('user.pembayaran');
    Route::post('/pembayaran/submit', [PaymentController::class, 'submitBayar']);

    // INVOICE DOWNLOAD
    Route::get('/pesanan/{id}/invoice', [InvoiceController::class, 'download'])->name('user.downloadinvoice');

    // PROFIL USER
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/profile/edit', [UserController::class, 'editProfile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
});

// ADMIN PANEL
Route::middleware(['auth', 'ceklogin:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen Pesanan
    Route::get('/kelola', [AdminController::class, 'kelolaPesanan'])->name('kelola');
    Route::post('/pesanan/update-massal', [AdminController::class, 'updateMassal'])->name('pesanan.updateMassal');
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
