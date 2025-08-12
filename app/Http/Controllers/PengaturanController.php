<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class PengaturanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Menampilkan halaman pengaturan profil & keamanan.
     */
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
    

    /**
     * Menangani update data profil & password admin.
     */
    public function update(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();

            if (!$admin instanceof Admin) {
                return redirect()->route('pengaturan.index')->with('error', 'Admin tidak ditemukan atau belum login.');
            }

            $rules = [
                'nama_pengguna' => 'sometimes|required|string|max:255',
                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    Rule::unique('admin')->ignore($admin->id),
                ],
                'current_password' => 'nullable|required_with:new_password|string',
                'new_password' => 'nullable|min:8|confirmed',
            ];

            $data = $request->validate($rules);

            $isNamaChanged = $request->filled('nama_pengguna') && $admin->nama_pengguna !== $request->nama_pengguna;
            $isPasswordChanged = $request->filled('new_password');

            if ($isNamaChanged) {
                $admin->nama_pengguna = $request->nama_pengguna;
            }

            if ($request->filled('email') && $admin->email !== $request->email) {
                $admin->email = $request->email;
            }

            if ($isPasswordChanged) {
                if (!Hash::check($request->current_password, $admin->password)) {
                    return redirect()->route('pengaturan')->with('error', 'Password lama tidak sesuai.');
                }
                $admin->password = Hash::make($request->new_password);
                $admin->last_password_changed_at = now();
            }

            // Jika menggunakan timestamps manual, update updated_at / dibuat_pada juga di sini
            // $admin->updated_at = now(); // kalau pakai kolom updated_at manual

            // Simpan hanya jika ada perubahan
            if ($admin->isDirty()) {
                $admin->save();
            }

            if ($isNamaChanged && $isPasswordChanged) {
                $message = 'Nama dan password berhasil diubah.';
            } elseif ($isNamaChanged) {
                $message = 'Nama berhasil diubah.';
            } elseif ($isPasswordChanged) {
                $message = 'Password berhasil diubah.';
            } else {
                $message = 'Profil berhasil diperbarui.';
            }

            return redirect()->route('pengaturan')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('pengaturan')->withErrors($e->errors())->with('error', 'Validasi gagal.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->route('pengaturan')->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return redirect()->route('pengaturan')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman keamanan (password terakhir diubah, login terakhir, dll)
     */
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

}
