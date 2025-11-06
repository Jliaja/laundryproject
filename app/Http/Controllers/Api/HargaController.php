<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Harga;

class HargaController extends Controller
{
    public function index()
    {
        $hargaList = Harga::all();
        return response()->json($hargaList);
    }
}
