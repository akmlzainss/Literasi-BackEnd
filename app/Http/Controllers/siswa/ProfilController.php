<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil siswa.
     */
    public function show()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('web_siswa.profil', compact('siswa'));
    }

    /**
     * Memperbarui data profil siswa.
     */
    public function update(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:siswa,email,' . $siswa->id,
            'kelas' => 'required|string|max:50',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        $data = $request->only('nama', 'email', 'kelas');

        // Proses upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($siswa->foto_profil) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }
            // Simpan foto baru
            $data['foto_profil'] = $request->file('foto_profil')->store('profil-siswa', 'public');
        }

        $siswa->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Memperbarui password siswa.
     */
    public function updatePassword(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'password_lama' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_lama, $siswa->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok.']);
        }

        $siswa->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}