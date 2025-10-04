<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VideoController extends Controller
{
    /**
     * Menampilkan halaman galeri video dengan layout grid.
     */
    public function index(Request $request)
    {
        $query = Video::where('status', 'disetujui')->with('siswa');

        // Pencarian berdasarkan judul
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        // Pengurutan
        if ($request->has('sort')) {
            if ($request->sort == 'terlama') {
                $query->oldest();
            } elseif ($request->sort == 'populer') {
                $query->orderBy('jumlah_dilihat', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $videos = $query->paginate(12)->appends($request->query());

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
    public function profil()
{
    $siswa = Auth::guard('siswa')->user();

    $videoDisukai = Video::whereHas('interaksi', function ($q) use ($siswa) {
        $q->where('id_siswa', $siswa->id)->where('jenis', 'suka');
    })->latest()->get();

    $videoDisimpan = Video::whereHas('interaksi', function ($q) use ($siswa) {
        $q->where('id_siswa', $siswa->id)->where('jenis', 'bookmark');
    })->latest()->get();

    return view('siswa.profil', compact('siswa', 'videoDisukai', 'videoDisimpan'));
}


    /**
     * Menyimpan video baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'video' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
            'id_kategori' => 'nullable|exists:kategori,id',
        ]);

        $videoFilePath = $request->file('video')->getPathname();

        // Validasi durasi video pakai FFProbe
        $ffprobe = \FFMpeg\FFProbe::create();
        $duration = $ffprobe->format($videoFilePath)->get('duration');

        if ($duration > 60) {
            return back()->withErrors(['video' => 'Durasi video tidak boleh lebih dari 1 menit.']);
        }

        // Pastikan folder ada
        if (!file_exists(storage_path('app/public/videos'))) {
            mkdir(storage_path('app/public/videos'), 0777, true);
        }
        if (!file_exists(storage_path('app/public/thumbnails'))) {
            mkdir(storage_path('app/public/thumbnails'), 0777, true);
        }

        // Buka video dengan FFMpeg
        $ffmpeg = \FFMpeg\FFMpeg::create();
        $videoFile = $ffmpeg->open($videoFilePath);

        // Simpan video dengan kompresi
        $videoPath = 'videos/' . uniqid() . '.mp4';
        $format = new X264();
        $format->setAudioCodec("aac");
        $format->setKiloBitrate(1000);

        $videoFile->save($format, storage_path('app/public/' . $videoPath));

        // Buat thumbnail dari detik ke-1
        $thumbnailPath = 'thumbnails/' . uniqid() . '.jpg';
        $videoFile->frame(TimeCode::fromSeconds(1))
            ->save(storage_path('app/public/' . $thumbnailPath));

        // Resize thumbnail dengan Intervention Image v3 (pakai GD driver)
        $manager = new ImageManager(new Driver());
        $manager->read(storage_path('app/public/' . $thumbnailPath))
            ->cover(320, 180)
            ->save();

        // Simpan metadata ke database
        Video::create([
            'id_siswa' => Auth::guard('siswa')->id(),
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('video.index')->with('success', 'Video berhasil diupload dan menunggu persetujuan admin!');
    }
}
