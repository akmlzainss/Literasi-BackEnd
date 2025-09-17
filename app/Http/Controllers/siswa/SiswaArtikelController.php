<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class SiswaArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::where('id_siswa', auth()->guard('siswa')->id())
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->kategori, fn($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->jenis && $request->jenis === 'artikel', fn($q) => $q); // Hanya artikel untuk saat ini
        $artikels = $query->paginate(10);
        return view('siswa-web-artikel.artikel', compact('artikels'));
    }

    public function show($id)
    {
        $konten = Artikel::findOrFail($id);
        // Tambahkan logika untuk increment jumlah_dilihat jika perlu
        $konten->increment('jumlah_dilihat');
        return view('siswa-web-artikel.artikel-detail', compact('konten'));
    }
}