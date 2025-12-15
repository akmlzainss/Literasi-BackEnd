<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Video;
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
        $totalVideo    = Video::count();
        $totalSiswa    = Siswa::count();

        // Ambil 6 log terakhir saja (tanpa pagination)
        $logs = LogAdmin::with('admin')
            ->orderByDesc('created_at')
            ->limit(7)
            ->get();


        // Data untuk chart
        $chartData    = $this->getChartData();
        $statsData    = $this->getStatsData();
        $activityData = $this->getActivityData();

        return view('admin.dashboard', [
            'artikelCount'  => $totalArtikel,
            'kategoriCount' => $totalKategori,
            'videoCount'    => $totalVideo,
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

        $totalArtikelSiswa     = Artikel::where('id_siswa', auth('siswa')->id())->count();
        $totalPenghargaanSiswa = \App\Models\Penghargaan::where('id_siswa', auth('siswa')->id())->count();

        $artikelTerbaru = Artikel::latest()->take(5)->get();

        return view('siswa.dashboard', [
            'artikelSiswaCount'     => $totalArtikelSiswa,
            'penghargaanSiswaCount' => $totalPenghargaanSiswa,
            'artikelTerbaru'        => $artikelTerbaru,
        ]);
    }

    private function getChartData()
    {
        // Coba menggunakan id_kategori terlebih dahulu, lalu id_kategori
        $columnName = DB::getSchemaBuilder()->hasColumn('artikel', 'id_kategori') ? 'id_kategori' : 'id_kategori';

        if (DB::getSchemaBuilder()->hasColumn('artikel', $columnName)) {
            $artikelByCategory = DB::table('artikel')
                ->join('kategori', "artikel.{$columnName}", '=', 'kategori.id')
                ->where('artikel.status', 'disetujui')
                ->select('kategori.nama as nama_kategori', DB::raw('count(*) as total'))
                ->groupBy('kategori.id', 'kategori.nama')
                ->orderBy('total', 'desc')
                ->get();

            if ($artikelByCategory->count() > 0) {
                return [
                    'categoryNames' => $artikelByCategory->pluck('nama_kategori')->toArray(),
                    'categories'    => $artikelByCategory->pluck('total')->toArray(),
                ];
            }
        }

        // Fallback data
        return [
            'categoryNames' => ['Artikel', 'Kategori', 'Video', 'Siswa'],
            'categories'    => [
                Artikel::count(),
                Kategori::count(),
                Video::count(),
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
                Video::count(),
                Siswa::count(),
            ],
        ];
    }

    private function getActivityData()
    {
        $dates      = [];
        $activities = [];
        $artikelViews = [];
        $newUsers = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            if ($i == 0) {
                $dates[] = 'Hari ini';
            } elseif ($i == 1) {
                $dates[] = 'Kemarin';
            } else {
                $dates[] = $date->format('d M');
            }

            // Aktivitas admin
            $activityCount = LogAdmin::whereDate('created_at', $date->format('Y-m-d'))->count();

            // Views artikel per hari (simulasi - bisa diganti dengan data real)
            $viewsCount = Artikel::whereDate('created_at', $date->format('Y-m-d'))->sum('jumlah_dilihat') ?? 0;

            // Siswa baru per hari
            $newUserCount = Siswa::whereDate('created_at', $date->format('Y-m-d'))->count();

            $activities[] = $activityCount;
            $artikelViews[] = $viewsCount;
            $newUsers[] = $newUserCount;
        }

        return [
            'labels' => $dates,
            'data'   => $activities,
            'views'  => $artikelViews,
            'users'  => $newUsers,
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
