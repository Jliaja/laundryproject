<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HargaController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/harga', [HargaController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::get('/profile', [UserController::class, 'profile']);

    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::post('/pesanan', [PesananController::class, 'store']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);
    Route::put('/pesanan/{id}/cancel', [PesananController::class, 'cancel']);

    Route::post('/payment', [PaymentController::class, 'createTransaction']);
});


// Callback dari Midtrans
Route::post('/payment/callback', [PaymentController::class, 'callback']);
