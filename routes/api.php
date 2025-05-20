<?php

use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);
Route::post('/payment/create-transaction', [PaymentController::class, 'createTransaction']);
