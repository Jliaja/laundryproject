<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgetPassController extends Controller
{
    // Form input email
    public function formEmail()
    {
        return view('auth.kirimemail');
    }

    // Kirim OTP ke email jika ditemukan di database
    public function kirimKode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        // Simpan kode OTP dummy dan email di session
        Session::put('otp_kode', '12345');
        Session::put('email', $user->email);

        // Kirim email (dummy)
        Mail::raw("Kode verifikasi Anda adalah: 12345", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode Verifikasi Lupa Password');
        });

        return redirect()->route('verifikasi')->with('pesan', 'Kode verifikasi telah dikirim ke email Anda.');
    }

    // Form input kode OTP
    public function formKode()
    {
        return view('auth.verifikasi');
    }

    // Verifikasi OTP
    public function verifikasiKode(Request $request)
    {
        $request->validate([
            'kode' => 'required|numeric'
        ]);

        if ($request->kode === Session::get('otp_kode')) {
            return redirect()->route('password.reset.form');
        }

        return back()->with('error', 'Kode salah, coba lagi');
    }

    // Form reset password
    public function formResetPassword()
    {
        return view('auth.resetpassword');
    }

    // Simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', Session::get('email'))->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            Session::forget(['otp_kode', 'email']);

            return redirect()->route('login')->with('success', 'Password berhasil diubah.');
        }

        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
}
