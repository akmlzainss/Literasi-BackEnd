<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Artikel;
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

        $query = Penghargaan::with(['artikel', 'siswa', 'admin']);

        // filter search
        if ($request->filled('search')) {
            $query->where('deskripsi_penghargaan', 'like', '%' . $request->search . '%')
                ->orWhereHas('siswa', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%');
                });
        }

        // filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('bulan_tahun', $request->tahun);
        }

        $penghargaan = $query->latest('dibuat_pada')->paginate(6);
        $totalPenghargaan = Penghargaan::count();

        // default bulan sekarang
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $selectedMonthNumber = date('m', strtotime($selectedMonth));
        $selectedYear = date('Y', strtotime($selectedMonth));

        // daftar tahun tersedia
        $years = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->select(DB::raw('YEAR(diterbitkan_pada) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->values();

        $minYear = $years->min() ?? date('Y') - 5;
        $maxYear = $years->max() ?? date('Y') + 5;

        // artikel di bulan & tahun terpilih
        $artikel = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', $selectedMonthNumber)
            ->whereYear('diterbitkan_pada', $selectedYear)
            ->paginate(6);

        $siswa = Siswa::all();

        // artikel dengan rating tertinggi di bulan tersebut
        $highestRatedArtikel = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', $selectedMonthNumber)
            ->whereYear('diterbitkan_pada', $selectedYear)
            ->orderBy('nilai_rata_rata', 'desc')
            ->first();

        // top 5 artikel global
        $topArtikel = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->orderByDesc('nilai_rata_rata')
            ->take(5)
            ->get();

        return view('penghargaan.penghargaan', compact(
            'penghargaan',
            'totalPenghargaan',
            'artikel',
            'siswa',
            'selectedMonth',
            'highestRatedArtikel',
            'minYear',
            'maxYear',
            'topArtikel'
        ));
    }

    /**
     * Form tambah penghargaan
     */

    public function create()
    {
        $siswa = Siswa::all();
        $selectedMonth = now()->format('Y-m');

        // Ambil Top 5 artikel dengan rata-rata rating tertinggi
        $topArtikel = Artikel::leftJoin('rating_artikel', 'rating_artikel.id_artikel', '=', 'artikel.id')
            ->select('artikel.*', DB::raw('AVG(rating_artikel.rating) as rata_rating'))
            ->groupBy('artikel.id')
            ->orderByDesc('rata_rating')
            ->take(5)
            ->get();

        if ($topArtikel->isEmpty()) {
            // fallback: tanpa filter status
            $topArtikel = Artikel::leftJoin('rating_artikel', 'rating_artikel.id_artikel', '=', 'artikel.id')
                ->select('artikel.*', DB::raw('AVG(rating_artikel.rating) as rata_rating'))
                ->groupBy('artikel.id')
                ->orderByDesc('rata_rating')
                ->take(5)
                ->get();
        }



        return view('penghargaan.create', compact('siswa', 'selectedMonth', 'topArtikel'));
    }



    /**
     * Simpan penghargaan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_artikel' => 'required|exists:artikel,id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string|max:255',
        ]);

        $artikel = Artikel::find($validated['id_artikel']);
        $idSiswa = $artikel->id_siswa;

        $penghargaan = Penghargaan::create([
            'id_artikel' => $validated['id_artikel'],
            'id_siswa' => $idSiswa,
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $validated['jenis'],
            'bulan_tahun' => $validated['bulan_tahun'],
            'deskripsi_penghargaan' => $validated['deskripsi_penghargaan'],
            'dibuat_pada' => now(),
        ]);

        LogAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'jenis_aksi' => 'create',
            'aksi' => 'Menambahkan penghargaan untuk artikel: ' . $artikel->judul,
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

        return redirect()->route('penghargaan')
            ->with('');
    }

    /**
     * Form edit penghargaan (AJAX modal)
     */
    public function edit($id)
{
    $penghargaan = Penghargaan::findOrFail($id);

    $bulan = Carbon::parse($penghargaan->bulan_tahun)->month;
    $tahun = Carbon::parse($penghargaan->bulan_tahun)->year;

    $artikel = Artikel::with('siswa')
        ->where('status', 'disetujui')
        ->whereNotNull('diterbitkan_pada')
        ->whereMonth('diterbitkan_pada', $bulan)
        ->whereYear('diterbitkan_pada', $tahun)
        ->get()
        ->map(function ($a) {
            return [
                'id' => $a->id,
                'judul' => $a->judul,
                'rating' => $a->nilai_rata_rata ?? null,
                'gambar' => $a->gambar
                    ? asset('storage/artikel/' . $a->gambar)
                    : asset('images/default.jpg'),
                'siswa_nama' => $a->siswa->nama ?? 'Unknown',
                'siswa_kelas' => $a->siswa->kelas ?? '-',
            ];
        });

    // 👉 Debug isi variabel
    dd($artikel->toArray());
}


    /**
     * Update penghargaan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_artikel' => 'required|exists:artikel,id',
            'id_siswa' => 'required|exists:siswa,id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string|max:255',
        ]);

        $penghargaan = Penghargaan::findOrFail($id);

        $penghargaan->update([
            'id_artikel' => $request->id_artikel,
            'id_siswa' => $request->id_siswa,
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $request->jenis,
            'bulan_tahun' => $request->bulan_tahun,
            'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
        ]);

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

        return redirect()->route('penghargaan')
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

        return redirect()->route('penghargaan')
            ->with('success', 'Penghargaan berhasil dihapus.');
    }

    /**
     * Detail penghargaan
     */
    public function show($id)
    {
        $penghargaan = Penghargaan::with(['artikel', 'siswa', 'admin'])->findOrFail($id);

        $artikel = Artikel::where('status', 'disetujui')
            ->whereMonth('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->month)
            ->whereYear('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->year)
            ->get();

        $siswa = Siswa::all();

        $highestRatedArtikel = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->month)
            ->whereYear('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->year)
            ->orderBy('nilai_rata_rata', 'desc')
            ->first();

        $selectedMonth = Carbon::parse($penghargaan->bulan_tahun)->format('Y-m');

        return view('penghargaan.show', compact(
            'penghargaan',
            'artikel',
            'siswa',
            'highestRatedArtikel',
            'selectedMonth'
        ));
    }
}
