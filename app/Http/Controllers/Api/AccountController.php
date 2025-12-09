<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    // ------------------------ 1. REGISTER + KIRIM OTP ------------------------
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:50|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
            'address' => 'required|string|max:255',
        ]);

        // Buat user sementara dengan email_verified_at = null
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        // Kirim OTP via email
        Mail::raw("Kode OTP Anda: $otp (berlaku 5 menit)", function ($msg) use ($user) {
            $msg->to($user->email)->subject('Verifikasi Email Anda');
        });

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Silakan cek email untuk OTP verifikasi.',
            'data' => $user
        ], 201);
    }

    // ------------------------ 2. VERIFIKASI OTP ------------------------
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'kode'  => 'required'
        ]);

        $user = User::where('email', $request->email)
            ->where('otp', $request->kode)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Kode OTP salah'], 400);
        }

        if (now()->gt($user->otp_expired_at)) {
            return response()->json(['error' => 'Kode OTP kedaluwarsa'], 400);
        }

        // Aktifkan akun
        $user->email_verified_at = now();
        $user->otp = null;
        $user->otp_expired_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi!'
        ]);
    }

    // ------------------------ 3. RESET PASSWORD ------------------------
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'kode'      => 'required',
            'password'  => 'required|min:6|confirmed'
        ]);

        $user = User::where([
            ['email', $request->email],
            ['forgot_otp', $request->kode],
        ])->first();

        if (!$user) {
            return response()->json(['error' => 'Data tidak valid'], 400);
        }

        if (now()->gt($user->forgot_otp_expired_at)) {
            return response()->json(['error' => 'Kode OTP kedaluwarsa'], 400);
        }

        // Update password
        $user->password = Hash::make($request->password);
$user->forgot_otp = null;
$user->forgot_otp_expired_at = null;
$user->save();
        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset'
        ]);
    }
    
public function sendOtpForgot(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Email tidak ditemukan'], 404);
    }

    // generate OTP baru
    $otp = rand(100000, 999999);
    $user->forgot_otp = $otp;
$user->forgot_otp_expired_at = now()->addMinutes(5);
$user->save();


    // kirim email OTP
    Mail::raw("Kode OTP Anda: $otp (berlaku 5 menit)", function ($msg) use ($user) {
        $msg->to($user->email)->subject('Reset Password OTP');
    });

    return response()->json([
        'success' => true,
        'message' => 'OTP berhasil dikirim ke email Anda',
    ]);
}
public function verifyOtpForgot(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'kode'  => 'required'
    ]);

    $user = User::where('email', $request->email)
                ->where('forgot_otp', $request->kode)
                ->first();

    if (!$user) return response()->json(['error' => 'Kode OTP salah'], 400);
    if (now()->gt($user->forgot_otp_expired_at)) {
        return response()->json(['error' => 'Kode OTP kedaluwarsa'], 400);
    }

    return response()->json([
        'success' => true,
        'message' => 'OTP valid'
    ]);
}


    public function resendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'type'  => 'required|in:register,forgot',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) return response()->json(['error' => 'Email tidak ditemukan'], 404);

    if ($request->type == 'register') {
        if ($user->email_verified_at != null) {
            return response()->json(['error' => 'Email sudah diverifikasi'], 400);
        }
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();
        Mail::raw("Kode OTP Anda: $otp", fn($msg) => $msg->to($user->email)->subject('Verifikasi Email'));
    } else {
        $otp = rand(100000, 999999);
        $user->forgot_otp = $otp;
        $user->forgot_otp_expired_at = now()->addMinutes(5);
        $user->save();
        Mail::raw("Kode OTP Anda: $otp", fn($msg) => $msg->to($user->email)->subject('Reset Password OTP'));
    }

    return response()->json(['success' => true, 'message' => 'OTP berhasil dikirim']);
}

}
