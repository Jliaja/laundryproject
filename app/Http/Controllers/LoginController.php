<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'username' => 'required|string',
        'password' => 'required|string|min:1',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Cek apakah username berupa email
    $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $credentials = [
        $fieldType => $request->username,
        'password' => $request->password
    ];

    // Proses login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // Prevent session fixation

        // Debugging untuk memastikan ID numerik
        $user = Auth::user();
        Log::info('ID User setelah login: ' . $user->id); // Periksa di log apakah ID benar (numerik)

        // Arahkan berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
        } else {
            return redirect()->route('user.dashboard')->with('success', 'Login berhasil!');
        }
    }

    return back()->with('error', 'Username atau password salah.')->withInput();
}


    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // CSRF protection

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}