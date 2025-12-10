<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HargaController;
use App\Http\Controllers\Api\AccountController;

Route::post('/login', [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    // PAYMENT (API)
    Route::post('/payment/create-transaction', [PaymentController::class, 'createTransaction']);

    // DATA USER
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::match(['PUT', 'POST'], '/user/profile', [UserController::class, 'updateProfile']);

    // HARGA
    Route::get('/harga', [HargaController::class, 'index']);

    // PESANAN
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::post('/pesanan', [PesananController::class, 'store']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);
    Route::put('/pesanan/{id}/cancel', [PesananController::class, 'cancel']);
    Route::post('/apply-voucher', [PesananController::class, 'applyVoucher']);


    
});

// CALLBACK MIDTRANS (tidak pakai sanctum)
Route::post('/payment/callback', [MidtransController::class, 'handle']);
Route::any('/midtrans', function () {
    return response()->json(['status' => 'OK']);
});

// ------------------------ REGISTER ------------------------
Route::post('/account/register', [AccountController::class, 'register']);

// ------------------------ OTP ------------------------
Route::post('/account/verify-otp', [AccountController::class, 'verifyOtp']);
Route::post('/account/verify-otp-forgot', [AccountController::class, 'verifyOtpForgot']);
Route::post('/account/resend-otp', [AccountController::class, 'resendOtp']);
// ------------------------ RESET PASSWORD ------------------------
Route::post('/account/reset-password', [AccountController::class, 'resetPassword']);
Route::post('/account/send-otp-forgot', [AccountController::class, 'sendOtpForgot']);


