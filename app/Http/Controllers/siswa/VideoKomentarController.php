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
            return response()->json(['error' => 'Anda harus login untuk menambahkan komentar.'], 401);
        }

        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        $video = Video::findOrFail($id);

        $komentar = new KomentarVideo();
        $komentar->id_video = $video->id;
        $komentar->komentar = $request->komentar;
        $komentar->id_komentar_parent = $request->id_komentar_parent ?? null;
        $komentar->depth = $request->id_komentar_parent ? 1 : 0;

        if (Auth::guard('siswa')->check()) {
            $komentar->id_siswa = Auth::guard('siswa')->id();
            $komentar->id_admin = null;
        } elseif (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            $komentar->id_admin = Auth::guard('admin')->id() ?? Auth::guard('web')->id();
            $komentar->id_siswa = null;
        }

        $komentar->save();

        return response()->json([
            'success' => true,
            'komentar' => [
                'id' => $komentar->id,
                'komentar' => $komentar->komentar,
                'nama' => $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown'),
                'created_at' => $komentar->created_at->diffForHumans(),
            ],
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            return response()->json(['error' => 'Anda harus login untuk menghapus komentar.'], 401);
        }

        $komentar = KomentarVideo::findOrFail($id);

        $bolehHapus =
            (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) ||
            ((Auth::guard('admin')->check() || Auth::guard('web')->check()) && $komentar->id_admin == Auth::id());

        if ($bolehHapus) {
            $komentar->delete();
            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus.']);
        }

        return response()->json(['error' => 'Anda tidak berhak menghapus komentar ini.'], 403);
    }
}