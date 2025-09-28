<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Intervention\Image\ImageManager;




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

        // Validasi durasi video
        $ffmpeg = \FFMpeg\FFMpeg::create();
        $videoFile = $ffmpeg->open($request->file('video')->getPathname());

        $ffprobe = \FFMpeg\FFProbe::create();
        $duration = $ffprobe->format($request->file('video')->getPathname())->get('duration');

        if ($duration > 60) {
            return back()->withErrors(['video' => 'Durasi video tidak boleh lebih dari 1 menit.']);
        }

        // Kompresi video
        $videoPath = 'videos/' . uniqid() . '.mp4';
        $format = new \FFMpeg\Format\Video\X264('aac', 'libx264');
        $format->setKiloBitrate(1000); // Bitrate 1Mbps

        $videoFile->save(
            $format,
            storage_path('app/public/' . $videoPath)
        );

        // Buat thumbnail
        $thumbnailPath = 'thumbnails/' . uniqid() . '.jpg';
        $videoFile->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1))
            ->save(storage_path('app/public/' . $thumbnailPath));

        // Resize dengan Intervention Image
        // Resize dengan Intervention Image v3
        $manager = new ImageManager(['driver' => 'gd']); 
        $image = $manager->read(storage_path('app/public/' . $thumbnailPath))
            ->cover(320, 180)
            ->save();

        // Simpan ke database
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
