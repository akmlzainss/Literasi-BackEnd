<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\ValidationException;

class ArtikelController extends Controller
{
    /**
     * Menampilkan daftar semua artikel dengan filter dan paginasi.
     */
    public function index(Request $request)
    {
        Paginator::useBootstrapFive();

        try {
            $artikels = Artikel::with('kategori', 'siswa')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->input('search');
                    $query->where(function ($q) use ($search) {
                        $q->where('judul', 'like', "%{$search}%")
                            ->orWhere('isi', 'like', "%{$search}%")
                            ->orWhereHas('siswa', fn($q_siswa) => $q_siswa->where('nama', 'like', "%{$search}%"));
                    });
                })
                ->when($request->filled('kategori'), function ($query) use ($request) {
                    // Menggunakan id_kategori untuk filter yang lebih akurat
                    $query->where('id_kategori', $request->input('kategori'));
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->input('status'));
                })
                ->latest()
                ->paginate(9)
                ->appends($request->query());

            // Mengirim data kategori ke view untuk dropdown filter
            $kategoris = Kategori::orderBy('nama')->get();

            return view('artikel.artikel', compact('artikels', 'kategoris'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat artikel.');
        }
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('artikel.create');
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->prepareArtikelData($request);
            Artikel::create($data);
            return redirect()->route('artikel')->with('success', 'Artikel berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan artikel: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit($id)
    {
        try {
            $artikel = Artikel::with('kategori', 'siswa')->findOrFail($id);
            return view('artikel.edit', compact('artikel'));
        } catch (\Exception $e) {
            return redirect()->route('artikel')->with('error', 'Gagal memuat halaman edit artikel.');
        }
    }

    /**
     * Memperbarui artikel di database.
     */
    public function update(Request $request, $id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            $data = $this->prepareArtikelData($request, $artikel);
            $artikel->update($data);
            return redirect()->route('artikel')->with('success', 'Artikel berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating article ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui artikel.')->withInput();
        }
    }

    /**
     * Helper method untuk validasi dan persiapan data artikel.
     */
    private function prepareArtikelData(Request $request, Artikel $artikel = null): array
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:65000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_kategori' => 'nullable|exists:kategori,id',
            'penulis_type' => 'required|in:admin,siswa',
            'id_siswa' => 'required_if:penulis_type,siswa|nullable|exists:siswa,id',
            'jenis' => 'required|in:bebas,resensi_buku,resensi_film,video',
            'status' => 'required|in:draf,menunggu,disetujui,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string|max:1000',
        ]);

        $validated['isi'] = Purifier::clean($validated['isi']);

        if ($validated['penulis_type'] === 'admin') {
            $validated['id_siswa'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($artikel && $artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }
        
        $validated['diterbitkan_pada'] = $validated['status'] === 'disetujui' && (!$artikel || !$artikel->diterbitkan_pada) ? now() : ($artikel->diterbitkan_pada ?? null);

        return $validated;
    }

    /**
     * Menghapus artikel.
     */
    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $artikel->delete();
            return redirect()->route('artikel')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting article ' . $id . ': ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal menghapus artikel.');
        }
    }

    /**
     * Menampilkan detail artikel.
     */
    public function show($id)
    {
        try {
            $artikel = Artikel::with(['kategori', 'siswa', 'komentarArtikel'])->findOrFail($id);
            return view('artikel.show', compact('artikel'));
        } catch (\Exception $e) {
            Log::error('Error showing article ' . $id . ': ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat detail artikel.');
        }
    }

    /**
     * Mencari siswa untuk form Select2.
     */
    public function searchSiswa(Request $request)
    {
        try {
            $search = $request->input('term');
            $siswa = Siswa::where('nama', 'like', '%' . $search . '%')
                ->orWhere('nis', 'like', '%' . $search . '%')
                ->limit(10)
                ->get();

            $results = $siswa->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama . ' (' . $item->nis . ')',
                    'kelas' => $item->kelas,
                ];
            });

            // ==================================================================
            // PERBAIKAN UTAMA DI SINI:
            // Kembalikan ke format array sederhana yang diharapkan oleh
            // JavaScript Select2 di file Blade Anda.
            // ==================================================================
            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('Error searching siswa: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mencari siswa.'], 500);
        }
    }

    /**
     * Mengekspor data artikel ke CSV.
     */
    public function export()
    {
        // ... (Fungsi export Anda tidak perlu diubah dan sudah benar) ...
        try {
            $artikels = Artikel::with('kategori', 'siswa')->get();
            $filename = 'artikels_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($artikels) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Judul', 'Isi', 'Kategori', 'Penulis', 'Jenis', 'Status', 'Dibuat Pada', 'Diterbitkan Pada', 'Jumlah Dilihat', 'Jumlah Suka']);

                foreach ($artikels as $artikel) {
                    fputcsv($file, [
                        $artikel->id,
                        $artikel->judul,
                        strip_tags($artikel->isi),
                        $artikel->kategori->nama ?? 'Tanpa Kategori',
                        $artikel->penulis_nama,
                        $artikel->jenis,
                        $artikel->status,
                        $artikel->created_at ? $artikel->created_at->format('d M Y H:i') : '',
                        $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y H:i') : '',
                        $artikel->jumlah_dilihat,
                        $artikel->jumlah_suka,
                    ]);
                }
                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting articles: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal mengekspor data artikel.');
        }
    }
}
