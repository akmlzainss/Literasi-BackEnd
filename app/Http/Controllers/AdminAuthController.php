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
            try {
                $admin = Auth::guard('admin')->user();

                // Update the last_login_at timestamp for the admin
                Admin::where('id', $admin->id)->update(['last_login_at' => now()]);

                // Create a log entry for the successful login
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'login',
                    'aksi' => 'Admin berhasil login',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);

                // Regenerate the session to prevent session fixation attacks
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            } catch (Exception $e) {
                // Log any errors that occur during the post-login process
                Log::error('Error during login process: ' . $e->getMessage());
                Log::error('Error details: ' . $e->getTraceAsString());

                // Still allow the user to proceed even if logging fails
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
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
                'password' => Hash::make($request->password), // Using Hash::make() is correct
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
            Log::error('Error details: ' . $e->getTraceAsString());
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
                Log::error('Error during logout logging: ' . $e->getMessage());
                Log::error('Error details: ' . $e->getTraceAsString());
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

        if ($request->filled('new_password')) {
            // Check if the current password is correct
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah']);
            }

            /** @var \App\Models\Admin $admin */
            $admin = Auth::guard('admin')->user();

            $admin->forceFill([
                'password' => Hash::make($request->new_password),
            ])->save();


            try {
                // Create a log entry for the password update
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'update_password',
                    'aksi' => 'Admin mengubah password',
                    'referensi_tipe' => 'admin',
                    'referensi_id' => $admin->id,
                ]);
            } catch (Exception $e) {
                Log::error('Error saat membuat log update password: ' . $e->getMessage());
                Log::error('Detail error: ' . $e->getTraceAsString());
            }

            return redirect()->back()->with('success', 'Password berhasil diubah');
        }

        return redirect()->back()->with('info', 'Tidak ada perubahan password dilakukan.');
    }
}
