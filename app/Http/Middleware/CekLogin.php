<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekLogin
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika ada role yang diberikan, pastikan role user sesuai
        if ($role && Auth::user()->role != $role) {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}


