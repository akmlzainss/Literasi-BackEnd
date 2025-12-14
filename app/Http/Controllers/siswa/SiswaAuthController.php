<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller; 
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class SiswaAuthController extends Controller
{
    /**
     * Menampilkan halaman login & register untuk siswa
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login khusus siswa
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Login sebagai Siswa
        if (Auth::guard('siswa')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Update last login
            try {
                $siswa = Auth::guard('siswa')->user();
                if ($siswa && !$siswa->status_aktif) {
                    Auth::guard('siswa')->logout();
                    return back()->with('error', 'Akun Anda tidak aktif. Hubungi administrator.')->withInput($request->only('email'));
                }
            } catch (Exception $e) {
                Log::error("Error updating siswa login: " . $e->getMessage());
            }

            return redirect()->intended(route('dashboard-siswa'));
        }

        return back()->with('error', 'Email atau Password yang Anda masukkan salah.')->withInput($request->only('email'));
    }

    /**
     * Register siswa baru
     */
    public function register(Request $request)
    {
        Log::info('Registration attempt started', ['email' => $request->email, 'nama' => $request->nama]);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswa,nis',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:siswa,email|unique:admin,email',
            'password' => ['required', 'confirmed', 'min:8'],
            'terms' => 'accepted',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS ini sudah terdaftar di sistem.',
            'kelas.required' => 'Kelas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
        ]);

        try {
            Log::info('Validation passed, creating siswa');

            // Membuat siswa baru
            $siswa = Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status_aktif' => true,
            ]);

            Log::info('Siswa created successfully', ['siswa_id' => $siswa->id]);

            // Kirim notifikasi selamat datang jika helper tersedia
            if (class_exists('\App\Helpers\NotificationHelper')) {
                \App\Helpers\NotificationHelper::sistemNotifikasi(
                    $siswa->id,
                    'Selamat Datang di SIPENA! 🎉',
                    'Halo ' . $siswa->nama . '! Selamat bergabung dengan komunitas literasi SIPENA. Yuk mulai berbagi pengetahuan dengan menulis artikel pertama Anda!'
                );
            }

            return redirect()->route('siswa.login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
        } catch (Exception $e) {
            Log::error('Error registrasi siswa: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);
            return back()->with('error', 'Terjadi kesalahan saat mendaftarkan akun: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Logout siswa
     */
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('siswa.login')->with('success', 'Anda berhasil logout.');
    }
}

