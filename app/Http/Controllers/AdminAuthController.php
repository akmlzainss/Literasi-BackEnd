<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
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
            'password' => 'required|min:6',
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
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.admin');
    }
}