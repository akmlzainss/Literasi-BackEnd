<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Siswa;
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
     * FORM LOGIN
     */
    public function showLoginForm()
    {
        return view('auth.login-admin'); // Gunakan satu view login untuk admin dan siswa
    }

    public function showLoginFormSiswa()
    {
        return view('auth.login-siswa'); // Opsional, jika ingin terpisah
    }

    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,siswa', // Tambahkan validasi role
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        $role = $request->role;

        $guard = ($role === 'admin') ? 'admin' : 'siswa';
        $model = ($role === 'admin') ? Admin::class : Siswa::class;
        $redirectRoute = ($role === 'admin') ? 'dashboard' : 'dashboard-siswa';

        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            $user = Auth::guard($guard)->user();

            try {
                if ($role === 'admin') {
                    /** @var Admin $user */
                    $user->update(['last_login_at' => now()]);
                    LogAdmin::create([
                        'id_admin' => $user->id,
                        'jenis_aksi' => 'login',
                        'aksi' => 'Admin berhasil login',
                        'referensi_tipe' => 'admin',
                        'referensi_id' => $user->id,
                    ]);
                } else {
                    /** @var Siswa $user */
                    $user->update(['last_login_at' => now()]);
                }
            } catch (Exception $e) {
                Log::error("Error post-login $role " . $user->id . ': ' . $e->getMessage());
            }

            $request->session()->regenerate();
            return redirect()->intended(route($redirectRoute));
        }

        // Hapus cookie "remember me" jika tidak dicentang
        if (!$remember) {
            $request->session()->forget('remember_web_' . $guard . '_' . sha1($credentials['email']));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * REGISTER
     */
    public function showRegisterForm()
    {
        return view('auth.register-admin');
    }

    public function showRegisterFormSiswa()
    {
        return view('auth.register-siswa');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255|unique:admins,nama_pengguna',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $admin = Admin::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
            ]);

            LogAdmin::create([
                'id_admin' => $admin->id,
                'jenis_aksi' => 'register',
                'aksi' => 'Admin baru registrasi',
                'referensi_tipe' => 'admin',
                'referensi_id' => $admin->id,
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error registrasi admin: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registrasi gagal.'])->withInput();
        }
    }

    public function registerSiswa(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255|unique:siswa,nama_pengguna',
            'email' => 'required|email|unique:siswa,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $siswa = Siswa::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error registrasi siswa: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registrasi gagal.'])->withInput();
        }
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            try {
                LogAdmin::create([
                    'id_admin' => $admin->id,
                    'jenis_aksi' => 'logout',
                    'aksi' => 'Admin logout',
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

    public function logoutSiswa(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        if ($siswa) {
            try {
                $siswa->update(['last_logout_at' => now()]);
            } catch (Exception $e) {
                Log::error('Error logout siswa ' . $siswa->id . ': ' . $e->getMessage());
            }
        }

        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

    /**
     * UPDATE PASSWORD
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'
            ],
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
                'aksi' => 'Admin ganti password',
                'referensi_tipe' => 'admin',
                'referensi_id' => $admin->id,
            ]);

            DB::commit();
            return back()->with('success', 'Password berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error update password admin: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal mengubah password.']);
        }
    }

    public function updatePasswordSiswa(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'
            ],
        ]);

        if (!Hash::check($request->current_password, $siswa->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        DB::beginTransaction();
        try {
            $siswa->update([
                'password' => Hash::make($request->new_password),
                'last_password_changed_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', 'Password berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error update password siswa: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal mengubah password.']);
        }
    }
}