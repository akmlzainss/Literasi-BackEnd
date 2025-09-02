<?php

namespace App\Http\Controllers; // Pastikan namespace ini sesuai dengan lokasi file

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SiswaAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string|unique:siswa',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:siswa',
            'password' => 'required|string|min:6',
            'kelas' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'status_aktif' => true,
            // HAPUS BARIS 'dibuat_pada'. Laravel akan mengisinya otomatis sebagai 'created_at'.
        ]);

        $token = $siswa->createToken('siswa-token', ['siswa-access'])->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'token' => $token,
            'user' => $siswa
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::guard('siswa')->attempt($credentials)) {
            /** @var \App\Models\Siswa $siswa **/
            $siswa = Auth::guard('siswa')->user();
            $token = $siswa->createToken('siswa-token', ['siswa-access'])->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $siswa
            ]);
        }

        return response()->json(['error' => 'NIS/Email atau password salah.'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}