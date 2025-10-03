<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Artikel;
use App\Models\Video;
use App\Models\Siswa;
use App\Models\Notifikasi;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class PenghargaanController extends Controller
{
    /**
     * Tampilkan daftar penghargaan dengan filter & pagination
     */
    public function index(Request $request)
    {
        Paginator::useBootstrapFive();

        // bulan & tahun aktif
        $currentMonth = $request->input('month', now()->format('Y-m'));
        $currentMonthNumber = (int) date('m', strtotime($currentMonth));
        $currentYear = (int) date('Y', strtotime($request->input('year', date('Y', strtotime($currentMonth)))));
        $activeTab = $request->input('active_tab', 'artikel');

        // Perbarui currentMonth jika year di-override
        $currentMonth = sprintf('%d-%02d', $currentYear, $currentMonthNumber);

        // Query untuk daftar pemenang bulan ini
        $query = Penghargaan::with(['artikel', 'video', 'siswa', 'admin'])
            ->where('arsip', false)
            ->where(DB::raw("DATE_FORMAT(bulan_tahun, '%Y-%m')"), $currentMonth);

        if ($request->filled('search')) {
            $query->where('deskripsi_penghargaan', 'like', '%' . $request->search . '%')
                ->orWhereHas('siswa', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%');
                });
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $penghargaan = $query->latest('dibuat_pada')->get();
        $totalPenghargaan = Penghargaan::where('arsip', false)->count();

        // daftar tahun tersedia
        $years = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->select(DB::raw('YEAR(diterbitkan_pada) as year'))
            ->distinct()
            ->union(
                Video::where('status', 'disetujui')
                    ->whereNotNull('diterbitkan_pada')
                    ->select(DB::raw('YEAR(diterbitkan_pada) as year'))
            )
            ->pluck('year')
            ->sort()
            ->values();

        $minYear = $years->min() ?? now()->subYears(5)->year;
        $maxYear = $years->max() ?? now()->addYears(5)->year;

        // artikel bulan ini
        $artikelQuery = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', $currentMonthNumber)
            ->whereYear('diterbitkan_pada', $currentYear)
            ->with('siswa')
            ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
            ->select('artikel.*', DB::raw('AVG(rating_artikel.rating) as avg_rating'))
            ->groupBy('artikel.id');

        $artikel = $artikelQuery->orderByDesc('avg_rating')->get();
        $topArtikel = (clone $artikelQuery)->orderByDesc('avg_rating')->take(3)->get();

        // video bulan ini
        $videoQuery = Video::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', $currentMonthNumber)
            ->whereYear('diterbitkan_pada', $currentYear)
            ->with('siswa')
            ->leftJoin('interaksi_video', 'videos.id', '=', 'interaksi_video.id_video')
            ->select('videos.*', DB::raw('SUM(CASE WHEN interaksi_video.jenis = "like" THEN 1 ELSE 0 END) as jumlah_like'))
            ->groupBy('videos.id')
            ->orderByDesc('jumlah_like');

        $video = $videoQuery->get();
        $topVideo = (clone $videoQuery)->take(3)->get();

        $siswa = Siswa::all();

        return view('penghargaan.penghargaan', compact(
            'penghargaan',
            'totalPenghargaan',
            'artikel',
            'video',
            'topArtikel',
            'topVideo',
            'siswa',
            'currentMonth',
            'currentMonthNumber',
            'currentYear',
            'minYear',
            'maxYear',
            'activeTab'
        ));
    }

    /**
     * Form tambah penghargaan
     */
    public function create(Request $request)
    {
        $siswa = Siswa::all();
        $selectedMonth = $request->input('month', now()->format('Y-m') . '-01');

        $preSelectedType = $request->input('type', 'artikel');
        $preSelectedId = $request->input($preSelectedType . '_id');

        $monthNum = date('m', strtotime($selectedMonth));
        $year = date('Y', strtotime($selectedMonth));

        $errorMessage = null;
        if ($preSelectedType === 'artikel') {
            $topItems = Artikel::where('status', 'disetujui')
                ->whereMonth('diterbitkan_pada', $monthNum)
                ->whereYear('diterbitkan_pada', $year)
                ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
                ->leftJoin('siswa', 'artikel.id_siswa', '=', 'siswa.id')
                ->select('artikel.*', 'siswa.nama as siswa_nama', 'siswa.kelas as siswa_kelas', DB::raw('AVG(rating_artikel.rating) as rating'))
                ->groupBy('artikel.id', 'siswa.nama', 'siswa.kelas')
                ->orderByDesc('rating')
                ->take(5)
                ->get();

            $topItems = $topItems->map(function ($item) {
                $item->type = 'artikel';
                $item->rating = $item->rating ?? 0;
                return $item;
            });

            // Cek apakah preSelectedId valid
            if ($preSelectedId && !$topItems->contains('id', $preSelectedId)) {
                $errorMessage = 'Artikel yang dipilih tidak tersedia untuk bulan ini.';
                $preSelectedId = null; // Reset preSelectedId jika tidak valid
            }
        } else {
            $topItems = Video::where('status', 'disetujui')
                ->whereMonth('diterbitkan_pada', $monthNum)
                ->whereYear('diterbitkan_pada', $year)
                ->leftJoin('interaksi_video', 'videos.id', '=', 'interaksi_video.id_video')
                ->leftJoin('siswa', 'videos.id_siswa', '=', 'siswa.id')
                ->select('videos.*', 'siswa.nama as siswa_nama', 'siswa.kelas as siswa_kelas', DB::raw('SUM(CASE WHEN interaksi_video.jenis = "like" THEN 1 ELSE 0 END) as rating'))
                ->groupBy('videos.id', 'siswa.nama', 'siswa.kelas')
                ->orderByDesc('rating')
                ->take(5)
                ->get();

            $topItems = $topItems->map(function ($item) {
                $item->type = 'video';
                $item->rating = $item->rating ?? 0;
                return $item;
            });

            // Cek apakah preSelectedId valid
            if ($preSelectedId && !$topItems->contains('id', $preSelectedId)) {
                $errorMessage = 'Video yang dipilih tidak tersedia untuk bulan ini.';
                $preSelectedId = null; // Reset preSelectedId jika tidak valid
            }
        }

        return view('penghargaan.create', compact('siswa', 'selectedMonth', 'topItems', 'preSelectedType', 'preSelectedId', 'errorMessage'));
    }

    /**
     * Simpan penghargaan baru (artikel / video)
     */
    public function store(Request $request)
    {
        $type = $request->input('type', 'artikel');
        $idItem = $request->input('id_item');

        $validated = $request->validate([
            'id_item' => 'required|exists:' . ($type === 'artikel' ? 'artikel' : 'videos') . ',id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string|max:255',
        ]);

        $item = ($type === 'artikel' ? Artikel::find($validated['id_item']) : Video::find($validated['id_item']));
        $idSiswa = $item->id_siswa;

        $penghargaanData = [
            'id_siswa' => $idSiswa,
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $validated['jenis'],
            'bulan_tahun' => $validated['bulan_tahun'],
            'deskripsi_penghargaan' => $validated['deskripsi_penghargaan'],
            'dibuat_pada' => now(),
            'arsip' => false,
        ];

        if ($type === 'artikel') {
            $penghargaanData['id_artikel'] = $validated['id_item'];
        } else {
            $penghargaanData['id_video'] = $validated['id_item'];
        }

        $penghargaan = Penghargaan::create($penghargaanData);

        // log & notif
        LogAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'jenis_aksi' => 'create',
            'aksi' => 'Menambahkan penghargaan untuk ' . $type . ': ' . $item->judul,
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'dibuat_pada' => now(),
        ]);

        Notifikasi::create([
            'id_siswa' => $idSiswa,
            'id_admin' => Auth::guard('admin')->id(),
            'judul' => 'Penghargaan Baru',
            'pesan' => 'Selamat! Anda menerima penghargaan ' . $validated['jenis'] . ': ' . $validated['deskripsi_penghargaan'],
            'jenis' => 'diberi_penghargaan',
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'sudah_dibaca' => false,
            'dibuat_pada' => now(),
        ]);

        return redirect()->route('admin.penghargaan.index')
            ->with('success', 'Penghargaan berhasil disimpan.');
    }

    /**
     * Reset bulanan (arsip pemenang lama)
     */
    public function resetMonthly($month = null)
    {
        $monthToArchive = $month ?? now()->subMonth()->format('Y-m');
        $updated = Penghargaan::where('bulan_tahun', 'like', $monthToArchive . '%')
            ->where('arsip', false)
            ->update(['arsip' => true]);

        if ($updated > 0) {
            return redirect()->route('admin.penghargaan.index')
                ->with('success', "Penghargaan bulan {$monthToArchive} berhasil diarsipkan ({$updated} item).");
        } else {
            return redirect()->route('admin.penghargaan.index')
                ->with('info', 'Tidak ada penghargaan untuk diarsipkan.');
        }
    }

    /**
     * Form edit penghargaan (AJAX modal)
     */
    public function edit($id)
    {
        $penghargaan = Penghargaan::with('siswa')->findOrFail($id);

        $bulan = Carbon::parse($penghargaan->bulan_tahun)->month;
        $tahun = Carbon::parse($penghargaan->bulan_tahun)->year;
        $type = $penghargaan->id_artikel ? 'artikel' : 'video';

        if ($type === 'artikel') {
            $itemsQuery = Artikel::where('status', 'disetujui')
                ->whereNotNull('diterbitkan_pada')
                ->whereMonth('diterbitkan_pada', $bulan)
                ->whereYear('diterbitkan_pada', $tahun)
                ->with('siswa')
                ->leftJoin('rating_artikel', 'artikel.id', '=', 'rating_artikel.id_artikel')
                ->select('artikel.id', 'artikel.judul', 'artikel.gambar', DB::raw('AVG(rating_artikel.rating) as rating'))
                ->groupBy('artikel.id');
        } else {
            $itemsQuery = Video::where('status', 'disetujui')
                ->whereNotNull('diterbitkan_pada')
                ->whereMonth('diterbitkan_pada', $bulan)
                ->whereYear('diterbitkan_pada', $tahun)
                ->with('siswa')
                ->leftJoin('interaksi_video', 'videos.id', '=', 'interaksi_video.id_video')
                ->select('videos.id', 'videos.judul', 'videos.thumbnail_path', DB::raw('SUM(CASE WHEN interaksi_video.jenis = "like" THEN 1 ELSE 0 END) as rating'))
                ->groupBy('videos.id');
        }

        $items = $itemsQuery->get()->map(function ($item) use ($type) {
            $image_path = $type === 'artikel' ? $item->gambar : $item->thumbnail_path;
            $folder = $type === 'artikel' ? 'artikel/' : 'videos/';

            return [
                'id' => $item->id,
                'judul' => $item->judul,
                'rating' => $item->rating ?? 0,
                'gambar_url' => $image_path ? asset('storage/' . $folder . $image_path) : asset('images/default.jpg'),
                'siswa_nama' => $item->siswa->nama ?? 'Unknown',
                'siswa_kelas' => $item->siswa->kelas ?? '-',
            ];
        });

        return response()->json([
            'penghargaan' => $penghargaan,
            'items' => $items,
            'type' => $type,
        ]);
    }

    /**
     * Update penghargaan (artikel / video)
     */
    public function update(Request $request, $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        $type = $request->input('type', $penghargaan->id_artikel ? 'artikel' : 'video');

        $request->validate([
            'id_item' => 'required|exists:' . ($type === 'artikel' ? 'artikel' : 'videos') . ',id',
            'id_siswa' => 'required|exists:siswa,id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string|max:255',
        ]);

        $penghargaanData = [
            'id_siswa' => $request->id_siswa,
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $request->jenis,
            'bulan_tahun' => $request->bulan_tahun,
            'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
        ];

        if ($type === 'artikel') {
            $penghargaanData['id_artikel'] = $request->id_item;
            $penghargaanData['id_video'] = null;
        } else {
            $penghargaanData['id_video'] = $request->id_item;
            $penghargaanData['id_artikel'] = null;
        }

        $penghargaan->update($penghargaanData);

        LogAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'jenis_aksi' => 'update',
            'aksi' => 'Mengedit penghargaan ID: ' . $penghargaan->id,
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'dibuat_pada' => now(),
        ]);

        Notifikasi::create([
            'id_siswa' => $request->id_siswa,
            'id_admin' => Auth::guard('admin')->id(),
            'judul' => 'Penghargaan Diperbarui',
            'pesan' => 'Penghargaan Anda diperbarui: ' . $request->deskripsi_penghargaan,
            'jenis' => 'diberi_penghargaan',
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'sudah_dibaca' => false,
            'dibuat_pada' => now(),
        ]);

        return redirect()->route('admin.penghargaan.index')
            ->with('success', 'Penghargaan berhasil diperbarui.');
    }

    /**
     * Hapus penghargaan
     */
    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        if ($adminId = Auth::guard('admin')->id()) {
            LogAdmin::create([
                'id_admin' => $adminId,
                'jenis_aksi' => 'delete',
                'aksi' => 'Menghapus penghargaan ID: ' . $penghargaan->id,
                'referensi_tipe' => 'penghargaan',
                'referensi_id' => $penghargaan->id,
                'dibuat_pada' => now(),
            ]);
        }

        // hapus notifikasi terkait penghargaan ini
        Notifikasi::where('referensi_tipe', 'penghargaan')
            ->where('referensi_id', $penghargaan->id)
            ->delete();

        $penghargaan->delete();

        return redirect()->route('admin.penghargaan.index')
            ->with('success', 'Penghargaan berhasil dihapus.');
    }

    /**
     * Detail penghargaan
     */
    public function show($id)
    {
        $penghargaan = Penghargaan::with(['artikel', 'video', 'siswa', 'admin'])->findOrFail($id);

        $selectedMonth = Carbon::parse($penghargaan->bulan_tahun)->format('Y-m');
        $bulan = Carbon::parse($penghargaan->bulan_tahun)->month;
        $tahun = Carbon::parse($penghargaan->bulan_tahun)->year;

        $artikel = Artikel::where('status', 'disetujui')
            ->whereMonth('diterbitkan_pada', $bulan)
            ->whereYear('diterbitkan_pada', $tahun)
            ->get();

        $video = Video::where('status', 'disetujui')
            ->whereMonth('diterbitkan_pada', $bulan)
            ->whereYear('diterbitkan_pada', $tahun)
            ->get();

        $siswa = Siswa::all();

        return view('penghargaan.show', compact(
            'penghargaan',
            'artikel',
            'video',
            'siswa',
            'selectedMonth'
        ));
    }
}
