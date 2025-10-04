<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\InteraksiVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoInteraksiController extends Controller
{
    public function store(Request $request, $id)
    {
        // Pastikan user login dengan guard siswa
        if (!Auth::guard('siswa')->check()) {
            return response()->json([
                'success' => false,
                'error' => 'Anda harus login untuk menambahkan interaksi.'
            ], 401);
        }

        // Validasi jenis interaksi
        $request->validate([
            'jenis' => 'required|in:suka,bookmark'
        ]);

        $video = Video::findOrFail($id);
        $siswaId = Auth::guard('siswa')->id();
        $jenis = $request->jenis;

        // Cek apakah interaksi sudah ada
        $existing = InteraksiVideo::where('id_video', $video->id)
            ->where('id_siswa', $siswaId)
            ->where('jenis', $jenis)
            ->first();

        if ($existing) {
            $existing->delete();
            $action = 'removed';
        } else {
            InteraksiVideo::create([
                'id_video' => $video->id,
                'id_siswa' => $siswaId,
                'jenis' => $jenis,
            ]);
            $action = 'added';
        }

        // Hitung ulang jumlah interaksi
        $count = InteraksiVideo::where('id_video', $video->id)
            ->where('jenis', $jenis)
            ->count();

        return response()->json([
            'success' => true,
            'action' => $action,
            'jenis'  => $jenis,
            'count'  => $count,
        ]);
    }
}
