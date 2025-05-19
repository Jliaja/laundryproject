<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pesanan;

class PaymentController extends Controller
{public function callback(Request $request)
{
    return response()->json(['message' => 'Callback processed']);
}
}