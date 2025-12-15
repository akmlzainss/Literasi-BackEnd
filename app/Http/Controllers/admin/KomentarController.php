<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\KomentarArtikel;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    /**
     * Simpan komentar baru
     */
    public function store(Request $request, $id)
    {
        
        // Validasi input
        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        // Pastikan user login
        if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return back()->with('error', 'Anda harus login untuk menambahkan komentar.');
        }

        // Ambil artikel
        $artikel = Artikel::findOrFail($id);

        // Buat komentar baru
        $komentar = new KomentarArtikel();
        $komentar->id_artikel = $artikel->id;
        $komentar->komentar = $request->komentar;
        $komentar->id_komentar_parent = $request->id_komentar_parent ?? null;
        $komentar->depth = $request->id_komentar_parent ? 1 : 0;

        // Tentukan pemilik komentar
      if (Auth::guard('siswa')->check()) {
    // kalau siswa login
    $komentar->id_siswa = Auth::guard('siswa')->id();
    $komentar->id_admin = null;
} elseif (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
    // kalau admin login (pakai guard admin ATAU web)
    $komentar->id_admin = Auth::guard('admin')->id() ?? Auth::guard('web')->id();
    $komentar->id_siswa = null;
}

        

        $komentar->save();

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Hapus komentar
     */
    public function destroy($id)
    {
        $komentar = KomentarArtikel::findOrFail($id);

        // Pastikan user login
        if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return back()->with('error', 'Anda harus login untuk menghapus komentar.');
        }

        // Validasi kepemilikan komentar
        $bolehHapus =
            (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) ||
            ((Auth::guard('admin')->check() || Auth::guard('web')->check()) && $komentar->id_admin == Auth::id());

        if ($bolehHapus) {
            $komentar->delete();
            return back()->with('success', 'Komentar berhasil dihapus.');
        }

        return back()->with('error', 'Anda tidak berhak menghapus komentar ini.');
    }
}
