<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Import Str jika ingin menggunakan untuk OTP yang lebih aman
use App\Models\User;

class VerifController extends Controller
{
    // Menampilkan form untuk memasukkan email
    public function formEmail()
    {
        return view('auth.kirimemail');
    }

    // Mengirim kode verifikasi ke email
    public function kirimKode(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email|exists:users,email' // Pastikan email ada di database
        ]);

        // Ambil data user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        // Generate kode OTP (gunakan Str::random untuk keamanan lebih baik jika perlu)
        $kode = rand(100000, 999999);  // Ganti dengan Str::random(6) jika ingin menggunakan string acak
        Session::put('otp_kode', $kode);
        Session::put('email', $user->email);

        // Kirim email dengan kode verifikasi
        Mail::raw("Kode verifikasi Anda adalah: $kode", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode Verifikasi Lupa Password');
        });

        // Redirect ke form verifikasi setelah email dikirim
        return redirect()->route('verifikasi')->with('pesan', 'Kode verifikasi telah dikirim ke email Anda.');
    }

    // Menampilkan form untuk memasukkan kode OTP
    public function formKode()
    {
        return view('auth.verifikasi');
    }

    // Memverifikasi kode OTP yang dimasukkan
    public function verifikasiKode(Request $request)
    {
        // Validasi kode yang dimasukkan
        $request->validate([
            'kode' => 'required|numeric'
        ]);

        // Cek apakah kode yang dimasukkan sama dengan kode di session
        if ($request->kode == Session::get('otp_kode')) {
            // Jika kode benar, arahkan ke form reset password
            return redirect()->route('password.reset.form');
        }

        // Jika kode salah, kembali dengan pesan error
        return back()->with('pesan', '<span style="color:red;">Kode salah, coba lagi.</span>');
    }

    // Menampilkan form untuk reset password
    public function formResetPassword()
    {
        return view('auth.resetpassword');  // Mengubah nama blade menjadi resetpassword
    }

    // Mereset password pengguna
    public function resetPassword(Request $request)
    {
        // Validasi input password
        $request->validate([
            'password' => 'required|min:6|confirmed', // Pastikan password panjangnya minimal 6 dan terkonfirmasi
        ]);

        // Ambil data user berdasarkan email yang disimpan di session
        $user = User::where('email', Session::get('email'))->first();

        // Jika user ditemukan, reset password
        if ($user) {
            $user->password = Hash::make($request->password); // Hash password baru
            $user->save(); // Simpan perubahan

            // Hapus data OTP dan email dari session
            Session::forget(['otp_kode', 'email']);

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Password berhasil diubah.');
        }

        // Jika terjadi kesalahan, kembalikan dengan pesan error
        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
}
