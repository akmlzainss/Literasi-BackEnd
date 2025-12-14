<?php

use App\Http\Controllers\Controller;

namespace App\Http\Controllers\Admin;

use App\Models\Penghargaan;
use App\Models\Artikel;
use App\Models\Video;
use App\Models\Siswa;
use App\Models\Notifikasi;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenghargaanController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Tampilkan daftar penghargaan dengan filter OPTIMIZED
     */
    public function index(Request $request)
    {
        $currentMonth = $request->input('bulan_tahun', now()->format('Y-m'));
        $activeTab = $request->input('active_tab', 'artikel');
        $search = $request->input('search', '');

        // VALIDASI BULAN
        try {
            $parsedMonth = Carbon::createFromFormat('Y-m', $currentMonth);
            $currentMonth = $parsedMonth->format('Y-m');
        } catch (\Exception $e) {
            return redirect()->route('admin.penghargaan.index')->with('error', 'Format bulan tidak valid');
        }

        // ✅ FIXED: QUERY SEMUA PENGHARGAAAN (TIDAK BERUBAH)
        $penghargaan = Penghargaan::whereRaw("DATE_FORMAT(bulan_tahun, '%Y-%m') = ?", [$currentMonth])
            ->where('arsip', false)
            ->with(['siswa', 'artikel', 'video'])
            ->orderBy('id', 'desc')
            ->get();

        $penghargaan = $penghargaan->map(function ($item) {
            $item->type = $item->id_artikel ? 'artikel' : 'video';
            return $item;
        });

        $totalPenghargaan = $penghargaan->count();

        // 🔥 **ULTIMATE FIX: QUERY KEDUA TAB SELALU!**
        // ARTIKEL - SELALU QUERY
        $topArtikel = Artikel::where('status', 'disetujui')
            ->whereRaw("DATE_FORMAT(COALESCE(diterbitkan_pada, artikel.created_at), '%Y-%m') = ?", [$currentMonth])
            ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
            ->leftJoin('siswa', 'artikel.id_siswa', '=', 'siswa.id')
            ->select(
                'artikel.*',
                'siswa.nama',
                DB::raw('COALESCE(AVG(rating_artikel.rating), 0) as avg_rating')
            )
            ->groupBy('artikel.id')
            ->orderByDesc('avg_rating')
            ->take(3)
            ->get();

        $artikel = Artikel::where('status', 'disetujui')
            ->whereRaw("DATE_FORMAT(COALESCE(diterbitkan_pada, artikel.created_at), '%Y-%m') = ?", [$currentMonth])
            ->when($search, function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%");
            })
            ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
            ->leftJoin('siswa', 'artikel.id_siswa', '=', 'siswa.id')
            ->select(
                'artikel.*',
                'siswa.nama',
                DB::raw('COALESCE(AVG(rating_artikel.rating), 0) as avg_rating')
            )
            ->groupBy('artikel.id')
            ->orderByDesc('avg_rating')
            ->paginate(10);

        // VIDEO - SELALU QUERY  
        $topVideo = Video::where('status', 'disetujui')
            ->whereRaw("DATE_FORMAT(COALESCE(videos.diterbitkan_pada, videos.created_at), '%Y-%m') = ?", [$currentMonth])
            ->leftJoin('interaksi_video', 'videos.id', '=', 'interaksi_video.id_video')
            ->leftJoin('siswa', 'videos.id_siswa', '=', 'siswa.id')
            ->select(
                'videos.*',
                'siswa.nama',
                DB::raw('COALESCE(SUM(CASE WHEN interaksi_video.jenis = "like" THEN 1 ELSE 0 END), 0) as jumlah_like')
            )
            ->groupBy('videos.id')
            ->orderByDesc('jumlah_like')
            ->take(3)
            ->get();

        $video = Video::where('status', 'disetujui')
            ->whereRaw("DATE_FORMAT(COALESCE(videos.diterbitkan_pada, videos.created_at), '%Y-%m') = ?", [$currentMonth])
            ->when($search, function ($query) use ($search) {
                $query->where('videos.judul', 'like', "%{$search}%");
            })
            ->leftJoin('interaksi_video', 'videos.id', '=', 'interaksi_video.id_video')
            ->leftJoin('siswa', 'videos.id_siswa', '=', 'siswa.id')
            ->select(
                'videos.*',
                'siswa.nama',
                DB::raw('COALESCE(SUM(CASE WHEN interaksi_video.jenis = "like" THEN 1 ELSE 0 END), 0) as jumlah_like')
            )
            ->groupBy('videos.id', 'siswa.nama')
            ->orderByDesc('jumlah_like')
            ->paginate(10);

        return view('admin.penghargaan.penghargaan', compact(
            'currentMonth',
            'activeTab',
            'search',
            'topArtikel',
            'topVideo',
            'artikel',
            'video',
            'penghargaan',
            'totalPenghargaan'
        ));
    }
    /**
     * Form tambah penghargaan - SYNC 100%
     */
    public function create(Request $request)
    {
        $bulanTahun = $request->input('bulan_tahun');
        if (!$bulanTahun) {
            return redirect()->route('admin.penghargaan.index')->with('error', 'Parameter bulan_tahun wajib!');
        }

        $activeTab = $request->input('active_tab', 'artikel');
        $preSelectedId = $request->input($activeTab . '_id');
        $selectedMonth = Carbon::parse($bulanTahun)->format('Y-m');
        $preSelectedType = $activeTab;

        if ($preSelectedType === 'artikel') {
            $topItems = Artikel::where('status', 'disetujui')
                ->whereRaw("DATE_FORMAT(COALESCE(diterbitkan_pada, artikel.created_at), '%Y-%m') = ?", [$selectedMonth])
                ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
                ->leftJoin('siswa', 'artikel.id_siswa', '=', 'siswa.id')
                ->select(
                    'artikel.*',
                    'siswa.nama',
                    'siswa.kelas',
                    DB::raw('COALESCE(AVG(rating_artikel.rating), 0) as rating')
                )
                ->groupBy('artikel.id', 'siswa.nama', 'siswa.kelas')
                ->orderByDesc('rating')
                ->take(5)
                ->get();
        } else {
            $topItems = Video::where('status', 'disetujui')
                ->whereRaw("DATE_FORMAT(COALESCE(videos.diterbitkan_pada, videos.created_at), '%Y-%m') = ?", [$selectedMonth])
                ->leftJoin('interaksi_video', 'videos.id', '=', 'interaksi_video.id_video')
                ->leftJoin('siswa', 'videos.id_siswa', '=', 'siswa.id')
                ->select(
                    'videos.*',
                    'siswa.nama',
                    'siswa.kelas',
                    DB::raw('COALESCE(SUM(CASE WHEN interaksi_video.jenis = "like" THEN 1 ELSE 0 END), 0) as rating')
                )
                ->groupBy('videos.id', 'siswa.nama', 'siswa.kelas')
                ->orderByDesc('rating')
                ->take(5)
                ->get();
        }

        if ($preSelectedId && !$topItems->pluck('id')->contains($preSelectedId)) {
            $namaBulan = Carbon::parse($selectedMonth)->translatedFormat('F Y');
            return redirect()->route('admin.penghargaan.index', [
                'bulan_tahun' => $bulanTahun,
                'active_tab' => $activeTab
            ])->with('error', ucfirst($preSelectedType) . ' TIDAK TERSEDIA untuk ' . $namaBulan);
        }

        return view('admin.penghargaan.create', compact(
            'selectedMonth',
            'topItems',
            'preSelectedType',
            'preSelectedId',
            'bulanTahun',
            'activeTab'
        ));
    }

    /**
     * Simpan penghargaan baru
     */
    public function store(Request $request)
    {
        $type = $request->input('type', 'artikel');

        $validated = $request->validate([
            'id_item' => 'required|exists:' . ($type === 'artikel' ? 'artikel' : 'videos') . ',id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string|max:255',
        ]);

        $bulanTahun = Carbon::parse($validated['bulan_tahun'])->startOfMonth();
        $item = ($type === 'artikel' ? Artikel::find($validated['id_item']) : Video::find($validated['id_item']));
        $idSiswa = $type === 'artikel' ? $item->id_siswa : $item->id_siswa;

        // CHECK DUPLICATE
        $exists = Penghargaan::where($type === 'artikel' ? 'id_artikel' : 'id_video', $validated['id_item'])
            ->whereRaw("DATE_FORMAT(bulan_tahun, '%Y-%m') = ?", [$bulanTahun->format('Y-m')])
            ->where('arsip', false)
            ->exists();

        if ($exists) {
            return back()->withErrors(['id_item' => 'Penghargaan sudah ada!']);
        }

        $penghargaanData = [
            'id_siswa' => $idSiswa,
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $validated['jenis'],
            'bulan_tahun' => $bulanTahun,
            'deskripsi_penghargaan' => $validated['deskripsi_penghargaan'],
            'dibuat_pada' => now(),
            'arsip' => false,
        ];

        if ($type === 'artikel') $penghargaanData['id_artikel'] = $validated['id_item'];
        else $penghargaanData['id_video'] = $validated['id_item'];

        $penghargaan = Penghargaan::create($penghargaanData);

        LogAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'jenis_aksi' => 'create',
            'aksi' => 'Menambahkan penghargaan: ' . $item->judul,
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'dibuat_pada' => now(),
        ]);

        Notifikasi::create([
            'id_siswa' => $idSiswa,
            'id_admin' => Auth::guard('admin')->id(),
            'judul' => 'Penghargaan Baru',
            'pesan' => 'Selamat! ' . $validated['deskripsi_penghargaan'],
            'jenis' => 'diberi_penghargaan',
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'sudah_dibaca' => false,
            'dibuat_pada' => now(),
        ]);

        return redirect()->route('admin.penghargaan.index', [
            'bulan_tahun' => $bulanTahun->format('Y-m'),
            'active_tab' => $request->input('active_tab', 'artikel')
        ])->with('success', 'Penghargaan berhasil disimpan!');
    }

    /**
     * Form edit (AJAX)
     */
    public function edit($id)
    {
        // Get penghargaan data
        $penghargaan = Penghargaan::with('siswa')->findOrFail($id);
        $type = $penghargaan->id_artikel ? 'artikel' : 'video';

        // Format month
        $currentMonth = date('Y-m', strtotime($penghargaan->bulan_tahun));

        // Get items based on type
        if ($type === 'artikel') {
            $items = Artikel::where('status', 'disetujui')
                ->whereRaw("DATE_FORMAT(COALESCE(diterbitkan_pada, created_at), '%Y-%m') = ?", [$currentMonth])
                ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
                ->select(
                    'artikel.id',
                    'artikel.judul',
                    DB::raw('COALESCE(AVG(rating_artikel.rating), 0) as rating')
                )
                ->groupBy('artikel.id', 'artikel.judul')
                ->orderByDesc('rating')
                ->get();
        } else {
            $items = DB::table('videos as v')
                ->where('v.status', 'disetujui')
                ->whereRaw("DATE_FORMAT(COALESCE(v.diterbitkan_pada, v.created_at), '%Y-%m') = ?", [$currentMonth])
                ->leftJoin('interaksi_video as iv', 'v.id', '=', 'iv.id_video')
                ->select(
                    'v.id',
                    'v.judul',
                    DB::raw('COALESCE(SUM(CASE WHEN iv.jenis = "like" THEN 1 ELSE 0 END), 0) as rating')
                )
                ->groupBy('v.id', 'v.judul')
                ->orderByDesc('rating')
                ->get();
        }

        // Get current item ID
        $currentItemId = $type === 'artikel' ? $penghargaan->id_artikel : $penghargaan->id_video;

        // Return JSON
        return response()->json([
            'success' => true,
            'penghargaan' => [
                'id' => $penghargaan->id,
                'id_siswa' => $penghargaan->id_siswa,
                'jenis' => $penghargaan->jenis,
                'bulan_tahun' => $currentMonth,
                'deskripsi_penghargaan' => $penghargaan->deskripsi_penghargaan,
                'siswa' => ['nama' => $penghargaan->siswa->nama ?? 'Unknown']
            ],
            'type' => $type,
            'current_item_id' => $currentItemId,
            'items' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'rating' => (float) $item->rating
                ];
            })->values()->toArray()
        ]);
    }

    /**
     * Update penghargaan
     */
    public function update(Request $request, $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $type = $request->input('type', $penghargaan->id_artikel ? 'artikel' : 'video');

        $validated = $request->validate([
            'id_item' => 'required|exists:' . ($type === 'artikel' ? 'artikel' : 'videos') . ',id',
            'id_siswa' => 'required|exists:siswa,id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string|max:255',
        ]);

        $bulanTahun = Carbon::parse($validated['bulan_tahun'])->startOfMonth();

        // CHECK DUPLICATE
        $exists = Penghargaan::where($type === 'artikel' ? 'id_artikel' : 'id_video', $validated['id_item'])
            ->whereRaw("DATE_FORMAT(bulan_tahun, '%Y-%m') = ?", [$bulanTahun->format('Y-m')])
            ->where('id', '!=', $id)
            ->where('arsip', false)
            ->exists();

        if ($exists) {
            return back()->withErrors(['id_item' => 'Penghargaan sudah ada!']);
        }

        $penghargaan->update([
            'id_siswa' => $validated['id_siswa'],
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $validated['jenis'],
            'bulan_tahun' => $bulanTahun,
            'deskripsi_penghargaan' => $validated['deskripsi_penghargaan'],
            ($type === 'artikel' ? 'id_artikel' : 'id_video') => $validated['id_item'],
            ($type === 'artikel' ? 'id_video' : 'id_artikel') => null,
        ]);

        return redirect()->route('admin.penghargaan.index', [
            'bulan_tahun' => $bulanTahun->format('Y-m'),
            'active_tab' => $request->input('active_tab', 'artikel')
        ])->with('success', 'Penghargaan berhasil diupdate!');
    }

    /**
     * Hapus penghargaan
     */
    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        LogAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'jenis_aksi' => 'delete',
            'aksi' => 'Menghapus penghargaan: ' . $penghargaan->deskripsi_penghargaan,
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $id,
            'dibuat_pada' => now(),
        ]);

        Notifikasi::where('referensi_tipe', 'penghargaan')->where('referensi_id', $id)->delete();
        $penghargaan->delete();

        return redirect()->route('admin.penghargaan.index', [
            'bulan_tahun' => request('bulan_tahun', now()->format('Y-m')),
            'active_tab' => request('active_tab', 'artikel')
        ])->with('success', 'Penghargaan berhasil dihapus!');
    }

    /**
     * ✅ FIXED: RENAME resetMonthly → reset()
     */
    public function reset()
    {
        $monthToArchive = now()->subMonth()->format('Y-m');
        $updated = Penghargaan::whereRaw("DATE_FORMAT(bulan_tahun, '%Y-%m') = ?", [$monthToArchive])
            ->where('arsip', false)
            ->update(['arsip' => true]);

        return redirect()->route('admin.penghargaan.index')
            ->with('success', "Berhasil mengarsipkan {$updated} penghargaan bulan lalu");
    }
}
