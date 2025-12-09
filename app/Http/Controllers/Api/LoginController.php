<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => 'required|string', // bisa username atau email
            'password' => 'required|string',
        ]);

        Log::info('Login attempt: ' . json_encode($request->only('login', 'password')));

        // Cari user berdasarkan username atau email
        $user = \App\Models\User::where('username', $request->login)
                ->orWhere('email', $request->login)
                ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::warning('Login gagal untuk: ' . $request->login);
            return response()->json([
                'success' => false,
                'message' => 'Username/email atau password salah'
            ], 401);
        }

        // Cek apakah email sudah diverifikasi
        if (is_null($user->email_verified_at)) {
            Log::warning('Login ditolak (belum verifikasi email) untuk: ' . $user->username);
            return response()->json([
                'success' => false,
                'message' => 'Silakan verifikasi email terlebih dahulu'
            ], 403);
        }

        // Generate token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        Log::info('Login BERHASIL untuk: ' . $user->username);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token
        ], 200);
    }
}
