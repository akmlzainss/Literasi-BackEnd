<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

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
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            try {
                $admin = Auth::guard('admin')->user();

                // Update last login menggunakan DB query langsung
                DB::table('admin')
                    ->where('id', $admin->id)
                    ->update(['last_login_at' => now()]);

                // Atau alternatif menggunakan model query
                // Admin::where('id', $admin->id)->update(['last_login_at' => now()]);

                // Log aktivitas login dengan error handling
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'login',
                    'aksi' => 'Admin berhasil login',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);

                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            } catch (Exception $e) {
                Log::error('Error during login process: ' . $e->getMessage());
                Log::error('Error details: ' . $e->getTraceAsString());
                // Tetap redirect meskipun logging gagal
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
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

        try {
            DB::beginTransaction();

            $admin = Admin::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
            ]);

            // Log aktivitas registrasi
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
            Log::error('Error during registration: ' . $e->getMessage());
            Log::error('Error details: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            try {
                // Log aktivitas logout
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'logout',
                    'aksi' => 'Admin melakukan logout',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);
            } catch (Exception $e) {
                Log::error('Error during logout logging: ' . $e->getMessage());
                Log::error('Error details: ' . $e->getTraceAsString());
                // Lanjutkan proses logout meskipun logging gagal
            }
        }

        $sessionId = $request->session()->getId();

        Auth::guard('admin')->logout();

        // Hapus session dari database jika menggunakan database driver
        if (config('session.driver') === 'database') {
            try {
                DB::table('sessions')->where('id', $sessionId)->delete();
            } catch (Exception $e) {
                Log::error('Error deleting session: ' . $e->getMessage());
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

   public function updatePassword(Request $request)
{
    $admin = Auth::guard('admin')->user();

    $request->validate([
        'current_password' => 'nullable|string',
        'new_password' => [
            'nullable',
            'string',
            'min:8',
            'confirmed',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/'
        ],
    ], [
        'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
    ]);

    if ($request->new_password) {
        if (!$request->current_password || !Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        // Log update password dengan try-catch
        try {
            LogAdmin::create([
                'id_admin' => $admin->id,
                'jenis_aksi' => 'update_password',
                'aksi' => 'Admin mengubah password',
                'referensi_tipe' => 'admin',
                'referensi_id' => $admin->id,
                'detail' => 'Password berhasil diubah',
                'dibuat_pada' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saat membuat log update password: '.$e->getMessage());
            \Log::error('Detail error: '.$e->getTraceAsString());
        }

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    return redirect()->back()->with('info', 'Tidak ada perubahan password dilakukan.');
}
}