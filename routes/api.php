<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;


// Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

Route::post('/test-post', function () {
    return response()->json(['message' => 'POST berhasil']);
});
