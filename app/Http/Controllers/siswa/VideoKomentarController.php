<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\KomentarVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoKomentarController extends Controller
{
    public function store(Request $request, $id)
    {
        if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk berkomentar.'], 401);
        }

        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        $video = Video::findOrFail($id);
        $komentar = new KomentarVideo();
        $komentar->id_video = $video->id;
        $komentar->komentar = $request->komentar;


        // --- PERBAIKAN PENTING DI SINI ---
        // Mengambil parent_id dari input form, bukan dari URL
        $komentar->id_komentar_parent = $request->input('id_komentar_parent', null);

        // --- PERBAIKAN: Mengambil parent ID dari request body, bukan URL ---
        $komentar->id_komentar_parent = $request->input('id_komentar_parent', null);
        $komentar->depth = $request->id_komentar_parent ? 1 : 0;



        if (Auth::guard('siswa')->check()) {
            $komentar->id_siswa = Auth::guard('siswa')->id();
        } elseif (Auth::guard('admin')->check() || Auth::guard('web')->check()) {

            $komentar->id_admin = Auth::guard('admin')->id() ?: Auth::guard('web')->id();

            // Menggunakan ID dari guard yang aktif
            $komentar->id_admin = Auth::guard('admin')->id() ?: Auth::guard('web')->id();
            $komentar->id_siswa = null;

        }

        $komentar->save();
        $komentar->load('siswa', 'admin'); // Load relasi agar bisa digunakan di view partial

        // Jika ini adalah balasan, kirim balik HTML-nya
        if ($komentar->id_komentar_parent) {
            // Kita akan membuat partial view sederhana untuk ini
            $html = view('partials.video_comment_item', ['komentar' => $komentar])->render();
            
            return response()->json([
                'success' => true,
                'new_comment_html' => $html,
                'is_reply' => true
            ]);
        }


        // --- PERBAIKAN: Mengirim HTML baru jika ini adalah balasan ---
        if ($komentar->id_komentar_parent) {
             $new_comment_html = view('partials.comment_reply_item', ['balasan' => $komentar])->render();
             return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim!',
                'new_comment_html' => $new_comment_html
             ]);
        }


        return response()->json([
            'success' => true,
            'komentar' => [
                'id' => $komentar->id,
                'komentar' => $komentar->komentar,
                'nama' => $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown'),
            ],
            'is_reply' => false
        ]);
    }

    /**
     * Menghapus komentar.
     *
     * --- PERBAIKAN UTAMA ADA DI SINI ---
     */
    public function destroy($id)
    {
        // Cek apakah ada user yang login (siswa, admin, atau web)
        if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk menghapus komentar.'], 401);
        }

        $komentar = KomentarVideo::findOrFail($id);

        // Logika 1: Admin (dari guard 'admin' atau 'web') bisa menghapus komentar apa pun.
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            $komentar->delete();
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus oleh admin.']);
        }

        // Logika 2: Siswa hanya bisa menghapus komentarnya sendiri.
        if (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) {
            $komentar->delete();
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus.']);
        }

        // Jika tidak memenuhi kondisi di atas, berarti tidak berhak.
        return response()->json(['success' => false, 'message' => 'Anda tidak berhak menghapus komentar ini.'], 403);
    }
}