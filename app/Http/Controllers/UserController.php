<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pesanan;

class UserController extends Controller
{
    /**
     * Tampilkan halaman profil.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Tampilkan halaman edit profil.
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.editprofile', compact('user'));
    }

    /**
     * Proses update profil user.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->address = $request->address;
        $user->email = $request->email;

        // Update foto profil jika ada
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
//     public function viewPilihPengambilan(Request $request)
// {
//     // Pastikan ID pesanan valid dan milik user
//     $pesanan = Pesanan::where('id', $request->pesanan_id)
//                       ->where('user_id', Auth::id())
//                       ->where('status', 'selesai')
//                       ->firstOrFail();

//     return view('user.pilihpengambilan', compact('pesanan'));
// }

// public function submitPilihPengambilan(Request $request)
// {
//     $request->validate([
//         'pesanan_id' => 'required|exists:pesanans,id',
//         'metode' => 'required|in:antar_jemput,datang_sendiri',
//     ]);

//     $pesanan = Pesanan::where('id', $request->pesanan_id)
//                       ->where('user_id', Auth::id())
//                       ->firstOrFail();

//     $pesanan->metode_pengambilan = $request->metode;
//     $pesanan->save();

//     return redirect()->route('user.pesanan')->with('success', 'Metode pengambilan berhasil dipilih.');
// }

}
