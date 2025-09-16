<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('siswa')->check()) {
            return $next($request);
        }

        return redirect()->route('login-siswa')->with('error', 'Anda harus login sebagai siswa untuk mengakses halaman ini.');
    }
}