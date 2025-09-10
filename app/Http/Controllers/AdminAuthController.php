<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan form login admin.
     */
    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember'); // ✅ aktifkan Remember Me

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            /** @var \App\Models\Admin $admin */
            $admin = Auth::guard('admin')->user();

            try {
                // Update last_login_at
                $admin->update(['last_login_at' => now()]);

                // Buat log login sukses
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'login',
                    'aksi' => 'Admin berhasil login',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);
            } catch (Exception $e) {
                Log::error('Error post-login admin ' . $admin->id . ': ' . $e->getMessage());
            }

            // Regenerasi session
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Tampilkan form registrasi admin.
     */
    public function showRegisterForm()
    {
        return view('auth.register-admin');
    }

    /**
     * Proses registrasi admin.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255|unique:admin,nama_pengguna',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama_pengguna.required' => 'Nama pengguna wajib diisi.',
            'nama_pengguna.unique' => 'Nama pengguna sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        DB::beginTransaction();
        try {
            /** @var \App\Models\Admin $admin */
            $admin = Admin::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
            ]);

            // Log registrasi
            LogAdmin::create([
                'id_admin' => $admin->id,
                'jenis_aksi' => 'register',
                'aksi' => 'Admin baru melakukan registrasi',
                'referensi_tipe' => 'admin',
                'referensi_id' => $admin->id,
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error registrasi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Proses logout admin.
     */
    public function logout(Request $request)
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            try {
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'logout',
                    'aksi' => 'Admin melakukan logout',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);
            } catch (Exception $e) {
                Log::error('Error logout logging admin ' . $admin->id . ': ' . $e->getMessage());
            }
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

    /**
     * Update password admin.
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
        ]);
        
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        DB::beginTransaction();
        try {
            $admin->update([
                'password' => Hash::make($request->new_password),
                'last_password_changed_at' => now(),
            ]);

            LogAdmin::create([
                'id_admin' => $admin->id,
                'jenis_aksi' => 'update_password',
                'aksi' => 'Admin mengubah password',
                'referensi_tipe' => 'admin',
                'referensi_id' => $admin->id,
            ]);
            
            DB::commit();
            return redirect()->back()->with('success', 'Password berhasil diubah.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error update password admin: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengubah password. Silakan coba lagi.']);
        }
    }
}
