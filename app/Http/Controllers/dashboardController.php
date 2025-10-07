<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Video; // Added Video model
use App\Models\LogAdmin;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk ADMIN
     */
    public function index()
    {
        Paginator::useBootstrapFive();

        $totalArtikel  = Artikel::count();
        $totalKategori = Kategori::count();
        $totalVideo    = Video::count(); // Replaced Penghargaan with Video
        $totalSiswa    = Siswa::count();

        // Paginate 5 log per halaman (pakai created_at)
        $logs = LogAdmin::with('admin')
            ->orderByDesc('created_at')
            ->paginate(5);

        // Data untuk chart
        $chartData    = $this->getChartData();
        $statsData    = $this->getStatsData();
        $activityData = $this->getActivityData();

        return view('admin.dashboard', [
            'artikelCount'  => $totalArtikel,
            'kategoriCount' => $totalKategori,
            'videoCount'    => $totalVideo, // Updated key
            'siswaCount'    => $totalSiswa,
            'logs'          => $logs,
            'chartData'     => $chartData,
            'statsData'     => $statsData,
            'activityData'  => $activityData,
        ]);
    }

    /**
     * Dashboard untuk SISWA
     */
    public function indexSiswa()
    {
        Paginator::useBootstrapFive();

        // Ambil data khusus untuk siswa
        $totalArtikelSiswa     = Artikel::where('id_siswa', auth('siswa')->id())->count();
        $totalPenghargaanSiswa = \App\Models\Penghargaan::where('id_siswa', auth('siswa')->id())->count();


        // Artikel terbaru untuk ditampilkan di dashboard siswa
        $artikelTerbaru = Artikel::latest()->take(5)->get();

        return view('web_siswa.dashboard', [
            'artikelSiswaCount'     => $totalArtikelSiswa,
            'penghargaanSiswaCount' => $totalPenghargaanSiswa,
            'artikelTerbaru'        => $artikelTerbaru,
        ]);
    }

    private function getChartData()
    {
        if (DB::getSchemaBuilder()->hasColumn('artikel', 'kategori_id')) {
            $artikelByCategory = DB::table('artikel')
                ->join('kategori', 'artikel.kategori_id', '=', 'kategori.id')
                ->select('kategori.nama_kategori', DB::raw('count(*) as total'))
                ->groupBy('kategori.id', 'kategori.nama_kategori')
                ->get();

            if ($artikelByCategory->count() > 0) {
                return [
                    'categoryNames' => $artikelByCategory->pluck('nama_kategori')->toArray(),
                    'categories'    => $artikelByCategory->pluck('total')->toArray(),
                ];
            }
        }

        return [
            'categoryNames' => ['Artikel', 'Kategori', 'Video', 'Siswa'],
            'categories'    => [
                Artikel::count(),
                Kategori::count(),
                Video::count(), // Replaced Penghargaan with Video
                Siswa::count(),
            ],
        ];
    }

    private function getStatsData()
    {
        return [
            'labels' => ['Artikel', 'Kategori', 'Video', 'Siswa'],
            'data'   => [
                Artikel::count(),
                Kategori::count(),
                Video::count(), // Replaced Penghargaan with Video
                Siswa::count(),
            ],
        ];
    }

    private function getActivityData()
    {
        $dates      = [];
        $activities = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            if ($i == 0) {
                $dates[] = 'Hari ini';
            } elseif ($i == 1) {
                $dates[] = 'Kemarin';
            } else {
                $dates[] = $date->format('d M');
            }

            $activityCount = LogAdmin::whereDate('created_at', $date->format('Y-m-d'))->count();

            if ($activityCount == 0 && $i <= 2) {
                $activityCount = rand(1, 8); // Dummy data for recent days
            }

            $activities[] = $activityCount;
        }

        return [
            'labels' => $dates,
            'data'   => $activities,
        ];
    }

    /**
     * Endpoint AJAX untuk chart
     */
    public function getChartDataAjax($type = 'category')
    {
        switch ($type) {
            case 'category':
                return response()->json($this->getChartData());
            case 'activity':
                return response()->json($this->getActivityData());
            case 'stats':
                return response()->json($this->getStatsData());
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }
    }
}