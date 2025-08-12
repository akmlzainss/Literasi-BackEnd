<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ], [
        'email.required' => 'Email wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        // Update last_login_at setelah berhasil login
        $admin = Auth::guard('admin')->user();
        $admin->last_login_at = now();
        $admin->save();

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
}

    public function showRegisterForm()
    {
        return view('auth.register-admin');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255|unique:admin',
            'email' => 'required|email|unique:admin',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama_pengguna.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Admin::create([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_aktif' => true,
            'created_at' => now(),
        ]);

        return redirect()->route('login.admin')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        $sessionId = $request->session()->getId();

        Auth::guard('admin')->logout();

        if (config('session.driver') === 'database') {
            DB::table('sessions')->where('id', $sessionId)->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}