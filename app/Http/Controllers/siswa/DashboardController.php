<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function indexSiswa(Request $request)
    {
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

        $artikelPopuler = Artikel::where('status', 'disetujui')
            ->orderByRaw('COALESCE(jumlah_dilihat, 0) + COALESCE(jumlah_suka, 0) DESC')
            ->take(10)
            ->get();

        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        return view('web_siswa.dashboard', compact('artikels', 'artikelPopuler', 'kategoris'));
    }
}