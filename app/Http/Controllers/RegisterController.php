<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register'); // Pastikan nama file view-nya sesuai
    }

    // Fungsi untuk registrasi
    public function register(Request $request)
    {
        // Validasi form
        $request->validate([
            'username' => 'required|min:3|max:50|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
            'address' => 'required|string|max:255', // Menambahkan validasi alamat
            'verifikasi_kode' => 'required|in:12345',
], [
    'verifikasi_kode.in' => 'Kode verifikasi salah. Silakan masukkan kode yang benar.',
        ]);

        // Menyimpan data user ke database
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
    }
}
