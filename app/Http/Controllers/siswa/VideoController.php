<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Menampilkan halaman galeri video dengan layout grid.
     */
    public function index()
    {
        // Untuk saat ini, kita tampilkan semua video yang disetujui
        $videos = Video::where('status', 'disetujui')->with('siswa')->latest()->paginate(12);

        return view('siswa-web-video.index', compact('videos'));
    }

    /**
     * Menampilkan halaman video dengan mode scroll ala TikTok.
     */
    public function tiktokView()
    {
        $videos = Video::where('status', 'disetujui')->with('siswa')->latest()->get();
        return view('siswa-web-video.tiktok', compact('videos'));
    }

    /**
     * Menampilkan form untuk upload video baru.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('siswa-web-video.create', compact('kategoris'));
    }

    /**
     * Menyimpan video baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'video' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200', // max 50MB
            'id_kategori' => 'nullable|exists:kategori,id',
        ]);

        $videoPath = $request->file('video')->store('videos', 'public');

        Video::create([
            'id_siswa' => Auth::guard('siswa')->id(),
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'video_path' => $videoPath,
            'status' => 'menunggu', // Perlu persetujuan admin
        ]);

        return redirect()->route('video.index')->with('success', 'Video berhasil diupload dan menunggu persetujuan admin!');
    }
}
