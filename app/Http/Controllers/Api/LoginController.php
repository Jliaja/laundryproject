<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('Login attempt: ' . json_encode($request->only('username', 'password')));

        // Coba login
        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            Log::info('Login BERHASIL untuk user: ' . $user->username);

            // Generate token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

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

        Log::warning('Login gagal untuk user: ' . $request->username);

        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah'
        ], 401);
    }
}
