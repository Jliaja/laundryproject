<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            "username" => $user->username,
            "email" => $user->email,
            "address" => $user->address,
            "profile_picture" => $user->profile_picture 
                ? url("picture_profile/" . $user->profile_picture)
                : null
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'address' => 'nullable',
            'profile_picture' => 'nullable|image',
            'password' => 'nullable|min:6'
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;

        $passwordUpdated = false;

        // UPDATE PASSWORD
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $passwordUpdated = true;
        }

        // UPDATE / REPLACE FOTO
        if ($request->hasFile('profile_picture')) {

            // hapus foto lama
            if ($user->profile_picture && file_exists(public_path("picture_profile/" . $user->profile_picture))) {
                unlink(public_path("picture_profile/" . $user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("picture_profile"), $filename);

            $user->profile_picture = $filename;
        }

        $user->save();

        // JIKA PASSWORD DIUBAH, TOKEN IKUT DIRESET
        $newToken = null;
        if ($passwordUpdated) {
            $user->tokens()->delete();
            $newToken = $user->createToken("auth_token")->plainTextToken;
        }

        return response()->json([
            "status" => true,
            "message" => "Profile updated successfully",
            "token" => $newToken // null jika password tidak diubah
        ]);
    }
}
