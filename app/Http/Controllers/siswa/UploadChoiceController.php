<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Artikel;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadChoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:siswa');
    }

    public function index()
    {
        $data = [
            'activeWriters' => Siswa::where('status_aktif', true)->count(),
            'publishedArticles' => Artikel::where('status', 'disetujui')->whereNotNull('diterbitkan_pada')->count(),
            'publishedVideos' => Video::where('status', 'disetujui')->whereNotNull('diterbitkan_pada')->count(),
            'userArticles' => Auth::guard('siswa')->check() ? Auth::guard('siswa')->user()->artikel()->count() : 0,
            'userVideos' => Auth::guard('siswa')->check() ? Auth::guard('siswa')->user()->video()->count() : 0,
        ];

        return view('siswa.artikel.upload-choice', $data);
    }
}
