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
     * Display the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

    /**
     * Handle an admin login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
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

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // Try to perform post-login actions like logging and updating timestamps
            try {
                // Update the last_login_at timestamp for the admin
                $admin->update(['last_login_at' => now()]);

                // Create a log entry for the successful login
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'login',
                    'aksi' => 'Admin berhasil login',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);
            } catch (Exception $e) {
                // Log any errors that occur, but still allow the user to proceed
                Log::error('Error during post-login process for admin ' . $admin->id . ': ' . $e->getMessage());
            }

            // Regenerate the session to prevent session fixation attacks and redirect
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Display the admin registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register-admin');
    }

    /**
     * Handle a new admin registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the registration data
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
            // Create the new admin record
            $admin = Admin::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
            ]);

            // Create a log entry for the registration
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
            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Handle admin logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            try {
                // Create a log entry for the logout event
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'logout',
                    'aksi' => 'Admin melakukan logout',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);
            } catch (Exception $e) {
                Log::error('Error during logout logging for admin ' . $admin->id . ': ' . $e->getMessage());
            }
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

    /**
     * Update the authenticated admin's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Validate the password update request
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
        
        // Check if the current password is correct
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        DB::beginTransaction();
        try {
            // Update the password and the timestamp
            $admin->update([
                'password' => Hash::make($request->new_password),
                'last_password_changed_at' => now(), // <-- Perubahan ditambahkan di sini
            ]);

            // Create a log entry for the password update
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
            Log::error('Error saat membuat log update password: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengubah password. Silakan coba lagi.']);
        }
    }
}