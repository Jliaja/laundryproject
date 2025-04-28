<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    // Tampilkan halaman profil (hanya lihat)
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user')); // tampilkan data user
    }

    // Tampilkan halaman edit profil
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.editprofile', compact('user')); // view khusus untuk edit
    }

    // Proses update profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'address' => 'nullable|string|max:255',  // Sesuaikan dengan kolom address
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',  // Validasi password jika diubah
        ]);

        // Update alamat
        $user->address = $request->address;  // Sesuaikan dengan kolom address

        // Handle foto profil
        if ($request->hasFile('profile_picture')) {
            // Hapus gambar lama jika ada
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Simpan gambar baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Update email
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->save();  // Pastikan ini dipanggil untuk menyimpan perubahan

        // Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
