<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function indexSiswa(Request $request)
    {
        $siswaId = auth('siswa')->id();

        // Query artikel dengan filter yang lebih baik
        $query = Artikel::query()->where('status', 'disetujui');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('isi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter berdasarkan rating
        if ($request->filled('rating')) {
            $rating = $request->rating;
            if ($rating == '5') {
                $query->where('nilai_rata_rata', '>=', 5);
            } elseif ($rating == '4') {
                $query->where('nilai_rata_rata', '>=', 4);
            } elseif ($rating == '3') {
                $query->where('nilai_rata_rata', '>=', 3);
            }
        }

        // Filter berdasarkan views
        if ($request->filled('views')) {
            $views = $request->views;
            if ($views == 'popular') {
                $query->where('jumlah_dilihat', '>=', 100);
            } elseif ($views == 'trending') {
                $query->where('jumlah_dilihat', '>=', 50);
            }
        }

        // Sorting yang lebih baik
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'populer':
                $query->orderByRaw('COALESCE(jumlah_dilihat, 0) DESC');
                break;
            case 'rating':
                $query->orderByRaw('COALESCE(nilai_rata_rata, 0) DESC');
                break;
            case 'terlama':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        $artikels = $query->with(['siswa', 'kategori'])->paginate(12);

        // Artikel populer HANYA dari bulan ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $artikelPopuler = Artikel::where('status', 'disetujui')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderByRaw('COALESCE(jumlah_dilihat, 0) DESC')
            ->take(10)
            ->get();

        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        // Statistik personal untuk siswa yang login
        $personalStats = [];
        if ($siswaId) {
            $personalStats = [
                'artikel_saya' => Artikel::where('id_siswa', $siswaId)->count(),
                'artikel_disetujui' => Artikel::where('id_siswa', $siswaId)->where('status', 'disetujui')->count(),
                'total_views' => Artikel::where('id_siswa', $siswaId)->sum('jumlah_dilihat') ?? 0,
                'total_likes' => Artikel::where('id_siswa', $siswaId)->sum('jumlah_suka') ?? 0,
                'avg_rating' => Artikel::where('id_siswa', $siswaId)->avg('nilai_rata_rata') ?? 0,
                'artikel_bookmark' => \App\Models\InteraksiArtikel::where('id_siswa', $siswaId)
                    ->where('jenis', 'bookmark')->count(),
                'komentar_saya' => \App\Models\KomentarArtikel::where('id_siswa', $siswaId)->count(),
                'penghargaan' => \App\Models\Penghargaan::where('id_siswa', $siswaId)->count(),
            ];
        }

        // Artikel yang di-bookmark siswa
        $artikelBookmark = collect([]);
        if ($siswaId) {
            $artikelBookmark = Artikel::whereHas('interaksi', function ($q) use ($siswaId) {
                $q->where('id_siswa', $siswaId)->where('jenis', 'bookmark');
            })->with(['siswa', 'kategori'])->latest()->take(6)->get();
        }

        // Rekomendasi berdasarkan kategori yang sering dibaca
        $rekomendasiArtikel = collect([]);
        if ($siswaId) {
            $kategoriSering = DB::table('interaksi_artikel')
                ->join('artikel', 'interaksi_artikel.id_artikel', '=', 'artikel.id')
                ->where('interaksi_artikel.id_siswa', $siswaId)
                ->where('interaksi_artikel.jenis', 'view')
                ->select('artikel.id_kategori', DB::raw('count(*) as total'))
                ->groupBy('artikel.id_kategori')
                ->orderBy('total', 'desc')
                ->first();

            if ($kategoriSering) {
                $rekomendasiArtikel = Artikel::where('status', 'disetujui')
                    ->where('id_kategori', $kategoriSering->id_kategori)
                    ->where('id_siswa', '!=', $siswaId)
                    ->orderBy('nilai_rata_rata', 'desc')
                    ->take(6)
                    ->get();
            }
        }

        return view('siswa.dashboard', compact(
            'artikels',
            'artikelPopuler',
            'kategoris',
            'personalStats',
            'artikelBookmark',
            'rekomendasiArtikel'
        ));
    }
}
