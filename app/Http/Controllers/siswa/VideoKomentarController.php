<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\KomentarVideo;
use App\Helpers\NotificationHelper;
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
        $komentar->id_komentar_parent = $request->input('id_komentar_parent', null);
        $komentar->depth = $komentar->id_komentar_parent ? 1 : 0;

        if (Auth::guard('siswa')->check()) {
            $komentar->id_siswa = Auth::guard('siswa')->id();
            $komentar->id_admin = null;
        } elseif (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            $komentar->id_admin = Auth::guard('admin')->id() ?: Auth::guard('web')->id();
            $komentar->id_siswa = null;
        }

        $komentar->save();
        $komentar->load('siswa', 'admin');

        // Kirim notifikasi jika ini adalah balasan komentar
        if ($komentar->id_komentar_parent) {
            $parentKomentar = KomentarVideo::find($komentar->id_komentar_parent);
            if ($parentKomentar && $parentKomentar->id_siswa && $parentKomentar->id_siswa != $komentar->id_siswa) {
                // Dapatkan nama yang membalas
                $namaYangMembalas = $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Seseorang');
                
                // Kirim notifikasi ke pemilik komentar parent
                NotificationHelper::balasanKomentarVideo(
                    $parentKomentar->id_siswa,
                    $namaYangMembalas,
                    $video->judul,
                    $video->id
                );
            }

            $html = view('partials.video_comment_item', ['komentar' => $komentar])->render();
            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim!',
                'new_comment_html' => $html,
                'is_reply' => true,
                'komentar' => [
                    'id' => $komentar->id,
                    'komentar' => $komentar->komentar,
                    'nama' => $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown'),
                ]
            ]);
        }

        // Kirim notifikasi untuk komentar baru (bukan balasan) ke pemilik video
        if ($video->id_siswa && $video->id_siswa != $komentar->id_siswa) {
            $namaKomentator = $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Seseorang');
            NotificationHelper::komentarBaruVideo(
                $video->id_siswa,
                $video->judul,
                $namaKomentator,
                $video->id
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim!',
            'komentar' => [
                'id' => $komentar->id,
                'komentar' => $komentar->komentar,
                'nama' => $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown'),
            ],
            'is_reply' => false
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk menghapus komentar.'], 401);
        }

        $komentar = KomentarVideo::findOrFail($id);

        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            $komentar->delete();
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus oleh admin.']);
        }

        if (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) {
            $komentar->delete();
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => 'Anda tidak berhak menghapus komentar ini.'], 403);
    }
}