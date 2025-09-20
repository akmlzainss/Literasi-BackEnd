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
        // Query untuk artikel terbaru (tidak berubah)
        $query = Artikel::query()->where('status', 'disetujui');
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        $artikels = $query->with(['siswa', 'kategori'])->latest()->paginate(12);

        // ======================================================
        // PERBAIKAN DI SINI: Filter artikel populer berdasarkan bulan ini
        // ======================================================
        $artikelPopuler = Artikel::where('status', 'disetujui')
                                 ->whereMonth('created_at', now()->month) // Hanya ambil artikel dari bulan ini
                                 ->whereYear('created_at', now()->year)   // Dan dari tahun ini
                                 ->orderBy('jumlah_dilihat', 'desc')
                                 ->take(10)
                                 ->get();

        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        return view('web_siswa.dashboard', compact('artikels', 'artikelPopuler', 'kategoris'));
    }
}