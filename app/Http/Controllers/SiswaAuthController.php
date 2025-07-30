<?php

/*
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class SiswaAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa',
            'nama' => 'required|string',
            'email' => 'required|email|unique:siswa',
            'password' => 'required|min:6',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_aktif' => true,
            'dibuat_pada' => now(),
        ]);

        $token = $siswa->createToken('siswa-token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('siswa')->attempt($credentials)) {
            $siswa = Auth::guard('siswa')->user();
            $token = $siswa->createToken('siswa-token')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Email atau password salah'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
    */