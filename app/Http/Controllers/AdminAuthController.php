<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Siswa;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Exception;

class AdminAuthController extends Controller
{
    /**
     * Menampilkan form login & register yang sudah disatukan.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * LOGIN CERDAS: Tanpa perlu 'role' dari form.
     * Sistem akan otomatis mengecek ke tabel admin, lalu ke tabel siswa.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Prioritas 1: Coba login sebagai Admin
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            try {
                $admin = Auth::guard('admin')->user();
                if ($admin) {
                    $admin->update(['last_login_at' => now()]);
                    LogAdmin::create([
                        'id_admin' => $admin->id,
                        'jenis_aksi' => 'login',
                        'aksi' => 'Admin berhasil login',
                        'referensi_tipe' => 'admin',
                        'referensi_id' => $admin->id,
                    ]);
                }
            } catch (Exception $e) {
                Log::error("Gagal mencatat log login admin: " . $e->getMessage());
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        // Prioritas 2: Coba login sebagai Siswa
        if (Auth::guard('siswa')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard-siswa'));
        }
        
        return back()->with('error', 'Email atau Password yang Anda masukkan salah.')->withInput($request->only('email', 'remember'));
    }

    /**
     * REGISTRASI AMAN: Controller ini hanya akan memproses registrasi Siswa.
     */
    public function register(Request $request)
    {
        // KEAMANAN: Pastikan form hanya memproses jika 'role' dari hidden input adalah 'siswa'
        if ($request->input('role') !== 'siswa') {
            return redirect()->route('login')->with('error', 'Registrasi tidak diizinkan.');
        }

        // Validasi field dari form registrasi siswa
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswa,nis',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:siswa,email|unique:admin,email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()], // Password lebih kuat
            'terms' => 'accepted',
        ], [
            'nis.unique' => 'NIS ini sudah terdaftar di sistem.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan kami.',
        ]);

        try {
            // Membuat record baru di tabel 'siswa'
            Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
                'foto_profil' => null,
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
        } catch (Exception $e) {
            Log::error('Error registrasi siswa: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan. Gagal mendaftarkan akun.')->withInput();
        }
    }

    /**
     * LOGOUT ADMIN
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * LOGOUT SISWA
     */
    public function logoutSiswa(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}