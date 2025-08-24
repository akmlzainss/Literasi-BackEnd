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

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        Paginator::useBootstrapFive();

        try {
            // Menggunakan `when()` untuk query yang lebih bersih
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
                    $query->whereHas('kategori', fn($q) => $q->where('nama', $request->input('kategori')));
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->input('status'));
                })
                ->latest('dibuat_pada') // Urutkan berdasarkan yang terbaru
                ->paginate(9)
                ->appends($request->query());

            return view('artikel.artikel', compact('artikels'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat artikel.');
        }
    }

    public function create()
    {
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        try {
            // Memanggil helper method untuk validasi dan persiapan data
            $data = $this->prepareArtikelData($request);

            Artikel::create($data);
            Log::info('Artikel created with data: ', $data);

            return redirect()->route('artikel')->with('success', 'Artikel berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error on store: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan artikel: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $artikel = Artikel::with('kategori', 'siswa')->findOrFail($id);
            return view('artikel.edit', compact('artikel'));
        } catch (\Exception $e) {
            Log::error('Error loading edit page for article ' . $id . ': ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat halaman edit artikel.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            // Memanggil helper method, passing artikel yang ada untuk update
            $data = $this->prepareArtikelData($request, $artikel);

            $artikel->update($data);
            Log::info('Artikel updated with ID ' . $id . ', Data: ', $data);

            return redirect()->route('artikel')->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error on update: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating article ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui artikel.');
        }
    }


    /**
     * Helper method untuk validasi dan persiapan data artikel.
     * Mengurangi duplikasi kode antara store() dan update().
     */
    private function prepareArtikelData(Request $request, Artikel $artikel = null): array
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:3500', // Naikkan sedikit batasnya untuk mengakomodasi tag HTML
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_kategori' => 'nullable|exists:kategori,id',
            'penulis_type' => 'required|in:admin,siswa',
            'id_siswa' => 'required_if:penulis_type,siswa|nullable|exists:siswa,id',
            'jenis' => 'required|in:bebas,resensi_buku,resensi_film,video',
            'status' => 'required|in:draf,menunggu,disetujui,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string|max:1000',
        ]);

        // 2. Gunakan Purifier untuk membersihkan konten 'isi'
        $validated['isi'] = Purifier::clean($validated['isi']);

        // Menangani logika penulis (siswa atau admin)
        $validated['id_siswa'] = $validated['penulis_type'] === 'siswa' ? $validated['id_siswa'] : null;

        // Menangani upload gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada saat update
            if ($artikel && $artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        // Menentukan tanggal terbit atau dibuat
        if (!$artikel) { // Jika ini adalah proses 'store' baru
            $validated['dibuat_pada'] = now();
        }
        $validated['diterbitkan_pada'] = $validated['status'] === 'disetujui' && (!$artikel || !$artikel->diterbitkan_pada) ? now() : ($artikel->diterbitkan_pada ?? null);

        return $validated;
    }


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

    public function show($id)
    {
        try {
            $artikel = Artikel::with(['kategori', 'siswa', 'komentarArtikel'])->findOrFail($id);
            return view('artikel.show', compact('artikel'));
        } catch (\Exception $e) {
            Log::error('Error loading article details: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat detail artikel.');
        }
    }

    public function export()
    {
        try {
            $artikels = Artikel::with('kategori', 'siswa')->get();
            $filename = 'artikels_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($artikels) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Judul', 'Isi', 'Kategori', 'Penulis', 'Jenis', 'Status', 'Dibuat Pada', 'Diterbitkan Pada', 'Jumlah Dilihat', 'Jumlah Suka', 'Jumlah Komentar']);

                foreach ($artikels as $artikel) {
                    fputcsv($file, [
                        $artikel->id,
                        $artikel->judul,
                        strip_tags($artikel->isi),
                        $artikel->kategori->nama ?? 'Tanpa Kategori',
                        $artikel->siswa->nama ?? ($artikel->penulis_type === 'admin' ? 'Admin' : 'Unknown'),
                        $artikel->jenis,
                        $artikel->status,
                        $artikel->dibuat_pada ? $artikel->dibuat_pada->format('d M Y') : '',
                        $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : '',
                        $artikel->jumlah_dilihat,
                        $artikel->jumlah_suka,
                        $artikel->komentarArtikel->count(),
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

    public function editAjax($id)
    {
        try {
            $artikel = Artikel::with('kategori', 'siswa')->findOrFail($id);
            return response()->json([
                'id' => $artikel->id,
                'judul' => $artikel->judul,
                'isi' => $artikel->isi,
                'gambar' => $artikel->gambar,
                'id_kategori' => $artikel->id_kategori,
                'id_siswa' => $artikel->id_siswa,
                'penulis_type' => $artikel->penulis_type,
                'jenis' => $artikel->jenis,
                'status' => $artikel->status,
                'alasan_penolakan' => $artikel->alasan_penolakan,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading edit data via AJAX: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data artikel.'], 500);
        }
    }

    public function searchSiswa(Request $request)
    {
        try {
            $search = $request->input('term');
            $siswa = Siswa::where('nama', 'like', '%' . $search . '%')
                ->orWhere('nis', 'like', '%' . $search . '%')
                ->get();

            $results = [];
            foreach ($siswa as $item) {
                $results[] = [
                    'id' => $item->id,
                    'text' => $item->nama . ' (' . $item->nis . ')',
                    'kelas' => $item->kelas,
                ];
            }

            return response()->json($results);
        } catch (\Exception $e) {
            Log::error('Error searching siswa: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mencari siswa.'], 500);
        }
    }
}
