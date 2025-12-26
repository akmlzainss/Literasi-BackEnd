<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil siswa.
     */
    public function show()
    {
        $siswa = Auth::guard('siswa')->user();

        if (!$siswa) {
            return redirect()->route('siswa.login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // ====== POSTINGAN SAYA (Video + Artikel yang diupload user) ======
        // Video uses id_siswa, Artikel also uses id_siswa in actual database
        $videoUpload = Video::where('id_siswa', $siswa->id)
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        $artikelUpload = Artikel::where('id_siswa', $siswa->id)
            ->where('status', 'published')
            ->latest()
            ->get();

        // ====== DISUKAI (Video + Artikel yang user sukai) ======
        $videoDisukai = Video::whereHas('interaksi', function ($q) use ($siswa) {
            $q->where('id_siswa', $siswa->id)->where('jenis', 'suka');
        })->latest()->get();

        $artikelDisukai = Artikel::whereHas('interaksi', function ($q) use ($siswa) {
            $q->where('id_siswa', $siswa->id)->where('jenis', 'suka');
        })->latest()->get();

        // ====== DISIMPAN (Video + Artikel yang user simpan) ======
        $videoDisimpan = Video::whereHas('interaksi', function ($q) use ($siswa) {
            $q->where('id_siswa', $siswa->id)->where('jenis', 'bookmark');
        })->latest()->get();

        $artikelDisimpan = Artikel::whereHas('interaksi', function ($q) use ($siswa) {
            $q->where('id_siswa', $siswa->id)->where('jenis', 'bookmark');
        })->latest()->get();

        // ====== STATISTIK PROFIL ======
        $totalPostingan = $videoUpload->count() + $artikelUpload->count();
        $totalSukaVideo = Video::where('id_siswa', $siswa->id)->sum('jumlah_suka');
        $totalSukaArtikel = Artikel::where('id_siswa', $siswa->id)->sum('jumlah_suka');
        $totalSukaDiterima = $totalSukaVideo + $totalSukaArtikel;

        return view('siswa.profil', compact(
            'siswa',
            'videoUpload',
            'artikelUpload',
            'videoDisukai',
            'videoDisimpan',
            'artikelDisukai',
            'artikelDisimpan',
            'totalPostingan',
            'totalSukaDiterima'
        ));
    }

    /**
     * Memperbarui data profil siswa.
     */
    public function update(Request $request)
    {
        try {
            $siswa = Auth::guard('siswa')->user();

            if (!$siswa) {
                return redirect()->route('siswa.login')->with('error', 'Anda harus login terlebih dahulu.');
            }

            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:siswa,email,' . $siswa->id,
                'kelas' => 'required|string|max:50',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $data = $request->only('nama', 'email', 'kelas');

            // Upload foto profil baru
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada dan bukan default
                if ($siswa->foto_profil && Storage::disk('public')->exists($siswa->foto_profil)) {
                    Storage::disk('public')->delete($siswa->foto_profil);
                }

                // Simpan foto baru
                $data['foto_profil'] = $request->file('foto_profil')->store('profil-siswa', 'public');
            }

            $siswa->update($data);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error in ProfilController@update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    /**
     * Memperbarui password siswa.
     */
    public function updatePassword(Request $request)
    {
        try {
            $siswa = Auth::guard('siswa')->user();

            if (!$siswa) {
                return redirect()->route('siswa.login')->with('error', 'Anda harus login terlebih dahulu.');
            }

            $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $siswa->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
            }

            $siswa->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            Log::error('Error in ProfilController@updatePassword: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah password.');
        }
    }
}
