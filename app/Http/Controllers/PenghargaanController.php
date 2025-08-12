<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Artikel;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class PenghargaanController extends Controller
{
    public function index(Request $request)
    {
        Paginator::useBootstrapFive(); // Menggunakan paginasi Bootstrap

        $query = Penghargaan::with(['artikel', 'siswa', 'admin']);

        if ($request->has('search') && $request->search != '') {
            $query->where('deskripsi_penghargaan', 'like', '%' . $request->search . '%')
                ->orWhereHas('siswa', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%');
                });
        }

        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('bulan_tahun', $request->tahun);
        }

        $penghargaan = $query->latest()->paginate(6);
        $totalPenghargaan = Penghargaan::count();

        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $selectedMonthNumber = date('m', strtotime($selectedMonth));
        $selectedYear = date('Y', strtotime($selectedMonth));
        
        $years = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->select(DB::raw('YEAR(diterbitkan_pada) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->values();

        $minYear = $years->min() ?? date('Y') - 5;
        $maxYear = $years->max() ?? date('Y') + 5;

        $artikel = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', $selectedMonthNumber)
            ->whereYear('diterbitkan_pada', $selectedYear)
            ->paginate(6);

        Log::info('Filtered Artikel Data:', [
            'count' => $artikel->count(),
            'data' => $artikel->toArray()
        ]);

        $siswa = Siswa::all();

        $highestRatedArtikel = Artikel::where('status', 'disetujui')
            ->whereNotNull('diterbitkan_pada')
            ->whereMonth('diterbitkan_pada', $selectedMonthNumber)
            ->whereYear('diterbitkan_pada', $selectedYear)
            ->orderBy('nilai_rata_rata', 'desc')
            ->first();

        return view('penghargaan.penghargaan', compact(
            'penghargaan',
            'totalPenghargaan',
            'artikel',
            'siswa',
            'selectedMonth',
            'highestRatedArtikel',
            'minYear',
            'maxYear'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_artikel' => 'nullable|exists:artikel,id',
            'id_siswa' => 'required|exists:siswa,id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string',
        ]);

        $penghargaan = Penghargaan::create([
            'id_artikel' => $request->id_artikel,
            'id_siswa' => $request->id_siswa,
            'id_admin' => Auth::guard('admin')->id(),
            'jenis' => $request->jenis,
            'bulan_tahun' => $request->bulan_tahun,
            'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
            'dibuat_pada' => now(),
        ]);

        Notifikasi::create([
            'id_siswa' => $request->id_siswa,
            'id_admin' => Auth::guard('admin')->id(),
            'judul' => 'Penghargaan Baru',
            'pesan' => 'Selamat! Anda menerima penghargaan ' . $request->jenis . ': ' . $request->deskripsi_penghargaan,
            'jenis' => 'diberi_penghargaan',
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'sudah_dibaca' => false,
            'dibuat_pada' => now(),
        ]);

        return redirect()->route('penghargaan')->with('success', 'Penghargaan berhasil ditambahkan dan notifikasi telah dikirim ke siswa.');
    }

    public function edit($id)
    {
        $penghargaan = Penghargaan::with(['artikel', 'siswa', 'admin'])->findOrFail($id);
        $artikel = Artikel::where('status', 'disetujui')
            ->whereMonth('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->month)
            ->whereYear('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->year)
            ->get();
        $siswa = Siswa::all();
        $highestRatedArtikel = Artikel::where('status', 'disetujui')
            ->whereMonth('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->month)
            ->whereYear('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->year)
            ->orderBy('nilai_rata_rata', 'desc')
            ->first();

        Log::info('Edit - Artikel data:', $artikel->toArray());
        Log::info('Edit - Highest rated artikel:', $highestRatedArtikel ? $highestRatedArtikel->toArray() : ['message' => 'Tidak ada artikel dengan rating tertinggi']);

        return response()->json([
            'penghargaan' => $penghargaan,
            'artikel' => $artikel,
            'siswa' => $siswa,
            'highestRatedArtikel' => $highestRatedArtikel,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_artikel' => 'nullable|exists:artikel,id',
            'id_siswa' => 'required|exists:siswa,id',
            'jenis' => 'required|in:bulanan,spesial',
            'bulan_tahun' => 'required|date',
            'deskripsi_penghargaan' => 'required|string',
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

        Notifikasi::create([
            'id_siswa' => $request->id_siswa,
            'id_admin' => Auth::guard('admin')->id(),
            'judul' => 'Penghargaan Diperbarui',
            'pesan' => 'Penghargaan Anda telah diperbarui: ' . $request->deskripsi_penghargaan,
            'jenis' => 'diberi_penghargaan',
            'referensi_tipe' => 'penghargaan',
            'referensi_id' => $penghargaan->id,
            'sudah_dibaca' => false,
            'dibuat_pada' => now(),
        ]);

        return redirect()->route('penghargaan')->with('success', 'Penghargaan berhasil diperbarui dan notifikasi telah dikirim ke siswa.');
    }

    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $penghargaan->delete();

        return redirect()->route('penghargaan')->with('success', 'Penghargaan berhasil dihapus.');
    }

    public function show($id)
    {
        $penghargaan = Penghargaan::with(['artikel', 'siswa', 'admin'])->findOrFail($id);
        $artikel = Artikel::where('status', 'disetujui')
            ->whereMonth('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->month)
            ->whereYear('diterbitkan_pada', Carbon::parse($penghargaan->bulan_tahun)->year)
            ->get();
        $siswa = Siswa::all();
        return view('penghargaan.show', compact('penghargaan', 'artikel', 'siswa'));
    }
}
