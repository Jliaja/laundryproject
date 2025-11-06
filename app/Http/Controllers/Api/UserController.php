<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'username' => 'sometimes|unique:users,username,'.$user->id,
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
        ]);

        if ($request->username) $user->username = $request->username;
        if ($request->email) $user->email = $request->email;

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'user' => $user
        ]);
    }
}
