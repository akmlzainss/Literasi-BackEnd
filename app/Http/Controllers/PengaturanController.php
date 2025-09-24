<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    public function updateProfile(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();

            if (!$admin instanceof Admin) {
                return redirect()->route('pengaturan')->with('error', 'Admin tidak ditemukan atau belum login.');
            }

            $rules = [
                'nama_pengguna' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('admin')->ignore($admin->id),
                ],
                'current_password' => 'nullable|required_with:new_password|string',
                'new_password' => 'nullable|min:8|confirmed',
            ];

            $data = $request->validate($rules);

            $isNamaChanged = $admin->nama_pengguna !== $request->nama_pengguna;
            $isEmailChanged = $admin->email !== $request->email;
            $isPasswordChanged = $request->filled('new_password');

            if ($isNamaChanged) {
                $admin->nama_pengguna = $request->nama_pengguna;
            }

            if ($isEmailChanged) {
                $admin->email = $request->email;
            }

            if ($isPasswordChanged) {
                if (!Hash::check($request->current_password, $admin->password)) {
                    return redirect()->route('profile.edit')->with('error', 'Password lama tidak sesuai.');
                }
                $admin->password = Hash::make($request->new_password);
                $admin->last_password_changed_at = now();
            }

            if ($admin->isDirty()) {
                $admin->save();
            }

            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('profile.edit')->withErrors($e->errors())->with('error', 'Validasi gagal.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->route('profile.edit')->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return redirect()->route('profile.edit')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ----------------- Pengaturan Umum -----------------
    public function update(Request $request)
    {
        // kode update pengaturan umum kamu tetap seperti semula
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
        $artikels    = Artikel::onlyTrashed()->get();
        $kategoris   = Kategori::onlyTrashed()->get();
        $siswas      = Siswa::onlyTrashed()->get();
        $penghargaan = Penghargaan::onlyTrashed()->get();

        return view('pengaturan.trash', compact('artikels', 'kategoris', 'siswas', 'penghargaan'));
    }

    public function restore($model, $id)
    {
        $class = $this->getModelClass($model);
        $class::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', ucfirst($model).' berhasil direstore.');
    }

    public function forceDelete($model, $id)
    {
        $class = $this->getModelClass($model);
        $class::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', ucfirst($model).' berhasil dihapus permanen.');
    }

    private function getModelClass($model)
    {
        return match($model) {
            'artikel'     => Artikel::class,
            'kategori'    => Kategori::class,
            'siswa'       => Siswa::class,
            'penghargaan' => Penghargaan::class,
            default       => abort(404),
        };
    }
}
