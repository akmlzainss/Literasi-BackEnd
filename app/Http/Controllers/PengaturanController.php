<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Siswa;
use App\Models\Penghargaan;

class PengaturanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // ----------------- Pengaturan Utama -----------------
    public function index()
    {
        \Carbon\Carbon::setLocale('id');
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(401, 'Admin belum login.');
        }

        $userAgent = request()->header('User-Agent');
        $perangkat = 'Perangkat Tidak Dikenali';

        if (strpos($userAgent, 'Windows') !== false) $perangkat = 'Windows';
        elseif (strpos($userAgent, 'Macintosh') !== false) $perangkat = 'MacOS';
        elseif (strpos($userAgent, 'Linux') !== false) $perangkat = 'Linux';
        elseif (strpos($userAgent, 'Android') !== false) $perangkat = 'Android';
        elseif (strpos($userAgent, 'iPhone') !== false) $perangkat = 'iPhone';

        $ipAddress = request()->ip();
        $isOnline = true;

        return view('pengaturan.pengaturan', compact('admin', 'perangkat', 'ipAddress', 'isOnline'));
    }

    // ----------------- Update Profil Admin -----------------
    public function update(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();

            if (!$admin instanceof Admin) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'Admin tidak ditemukan atau belum login.'], 401)
                    : redirect()->route('admin.pengaturan.index')->with('error', 'Admin tidak ditemukan atau belum login.');
            }

            $rules = [
                'nama_pengguna' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('admin')->ignore($admin->id),
                ],
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'current_password' => ['nullable', 'required_with:new_password', 'string', 'current_password:admin'],
                'new_password' => [
                    'nullable',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/'
                ],
            ];

            $messages = [
                'new_password.regex' => 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter khusus (!@#$%^&*).',
                'current_password.current_password' => 'Password saat ini tidak sesuai.',
                'profile_photo.image' => 'File harus berupa gambar (jpeg, png, jpg, gif).',
                'profile_photo.max' => 'Ukuran gambar maksimal 2MB.',
            ];

            $data = $request->validate($rules, $messages);

            // Update nama dan email
            $isNamaChanged = $admin->nama_pengguna !== $request->nama_pengguna;
            $isEmailChanged = $admin->email !== $request->email;

            if ($isNamaChanged) {
                $admin->nama_pengguna = $request->nama_pengguna;
            }

            if ($isEmailChanged) {
                $admin->email = $request->email;
            }

            // Update password
            if ($request->filled('new_password')) {
                $admin->password = Hash::make($request->new_password);
                $admin->last_password_changed_at = now();
            }

            // Update foto profil
            if ($request->hasFile('profile_photo')) {
                if ($admin->profile_photo_path) {
                    Storage::disk('public')->delete($admin->profile_photo_path);
                }
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $admin->profile_photo_path = $path;
            }

            if ($admin->isDirty()) {
                $admin->save();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Profil berhasil diperbarui.',
                    'profile_photo_url' => $admin->profile_photo_url,
                ]);
            }

            return redirect()->route('admin.pengaturan.index')->with('success', 'Profil berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Validasi gagal.', 'errors' => $e->errors()], 422);
            }
            return redirect()->route('admin.pengaturan.index')->withErrors($e->errors())->with('error', 'Validasi gagal.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Gagal menyimpan ke database.'], 500);
            }
            return redirect()->route('admin.pengaturan.index')->with('error', 'Gagal menyimpan ke database.');
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }
            return redirect()->route('admin.pengaturan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ----------------- Pengaturan Umum -----------------
    public function updateUmum(Request $request)
    {
        // Kode asli kamu untuk pengaturan umum
    }

    // ----------------- Keamanan -----------------
    public function keamanan()
    {
        $admin = auth()->guard('admin')->user();

        $userAgent = request()->header('User-Agent');
        $perangkat = 'Perangkat Tidak Dikenali';

        if (strpos($userAgent, 'Windows') !== false) $perangkat = 'Windows';
        elseif (strpos($userAgent, 'Macintosh') !== false) $perangkat = 'MacOS';
        elseif (strpos($userAgent, 'Linux') !== false) $perangkat = 'Linux';
        elseif (strpos($userAgent, 'Android') !== false) $perangkat = 'Android';
        elseif (strpos($userAgent, 'iPhone') !== false) $perangkat = 'iPhone';

        $ipAddress = request()->ip();

        return view('pengaturan.keamanan', compact('admin', 'perangkat', 'ipAddress'));
    }

    // ----------------- Trash & Restore -----------------
    public function trash()
    {
        // Pagination untuk setiap tabel dengan 10 data per halaman
        $artikels = Artikel::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'artikel_page');
        
        $kategoris = Kategori::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'kategori_page');
        
        $siswas = Siswa::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'siswa_page');
        
        $penghargaan = Penghargaan::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'penghargaan_page');

        return view('pengaturan.trash', compact('artikels', 'kategoris', 'siswas', 'penghargaan'));
    }

    public function restore($model, $id)
    {
        $class = $this->getModelClass($model);
        $class::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', ucfirst($model) . ' berhasil direstore.');
    }

    public function forceDelete($model, $id)
    {
        $class = $this->getModelClass($model);
        $class::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', ucfirst($model) . ' berhasil dihapus permanen.');
    }

    private function getModelClass($model)
    {
        return match ($model) {
            'artikel' => Artikel::class,
            'kategori' => Kategori::class,
            'siswa' => Siswa::class,
            'penghargaan' => Penghargaan::class,
            default => abort(404),
        };
    }
}