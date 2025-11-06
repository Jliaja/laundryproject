<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validasi form
        $request->validate([
            'username' => 'required|min:3|max:50|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
            'address' => 'required|string|max:255',
            'verifikasi_kode' => 'required|in:12345',
        ], [
            'verifikasi_kode.in' => 'Kode verifikasi salah. Silakan masukkan kode yang benar.',
        ]);

        // Simpan user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        // Return JSON response (buat Flutter)
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Silakan login.',
            'data' => $user
        ], 201);
    }
}
