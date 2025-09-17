<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexSiswa(Request $request)
    {
        $query = Artikel::query()->where('status', 'disetujui');

        // Filter pencarian berdasarkan kata kunci
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori dari link
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }

        // Filter berdasarkan bulan dan tahun
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereYear('created_at', $request->year)
                  ->whereMonth('created_at', $request->month);
        }

        // Urutkan berdasarkan terbaru (created_at DESC)
        $query->orderBy('created_at', 'desc');

        // Ambil data artikel dengan batas 12 per halaman
        $artikels = $query->with(['siswa', 'ratingArtikel', 'kategori'])
                          ->paginate(12);

        // Ambil data kategori
        $kategoris = Kategori::all();

        // Kirim kedua data ke view
        return view('web_siswa.dashboard', compact('artikels', 'kategoris'));
    }
}