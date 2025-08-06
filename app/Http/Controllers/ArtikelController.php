<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ArtikelController extends Controller
{
    // Tampilkan daftar artikel dengan search dan filter
    public function index(Request $request)
    {
        try {
            $query = Artikel::with('kategori', 'siswa')
                ->search($request->input('search'))
                ->applyFilter($request->input('filter'));

            $artikels = $query->paginate(9); // Ubah ke 9 items per page (3x3)

            return view('artikel.artikel', compact('artikels'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat artikel.');
        }
    }

    // Tampilkan form tambah artikel
    public function create()
    {
        try {
            return view('artikel.create');
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat form tambah artikel.');
        }
    }

    // Simpan artikel baru
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'id_kategori' => 'nullable|exists:kategori,id',
                'id_siswa' => 'required|exists:siswa,id',
                'jenis' => 'required|in:bebas,resensi_buku,resensi_film,video',
                'status' => 'required|in:draf,menunggu,disetujui,ditolak',
            ]);

            $data = array_merge($validated, [
                'dibuat_pada' => now(),
                'diterbitkan_pada' => $validated['status'] === 'disetujui' ? now() : null,
                'alasan_penolakan' => $validated['status'] === 'ditolak' ? $request->input('alasan_penolakan', null) : null,
            ]);

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('artikel', 'public');
                if ($gambarPath) {
                    $data['gambar'] = $gambarPath;
                    Log::info('Gambar disimpan untuk artikel baru: ' . $gambarPath);
                } else {
                    Log::error('Gagal menyimpan gambar untuk artikel baru. File: ' . $request->file('gambar')->getClientOriginalName());
                }
            }

            $artikel = Artikel::create($data);
            Log::info('Artikel dibuat dengan ID: ' . $artikel->id . ', Gambar: ' . ($data['gambar'] ?? 'Tidak ada'));

            return redirect()->route('artikel')->with('success', 'Artikel berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan artikel. Periksa log untuk detail.');
        }
    }

    // Tampilkan data untuk edit artikel (AJAX)
    public function edit($id)
    {
        try {
            $artikel = Artikel::with('kategori', 'siswa')->findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'id' => $artikel->id,
                    'judul' => $artikel->judul,
                    'isi' => $artikel->isi,
                    'gambar' => $artikel->gambar,
                    'id_kategori' => $artikel->id_kategori,
                    'id_siswa' => $artikel->id_siswa,
                    'jenis' => $artikel->jenis,
                    'status' => $artikel->status,
                ]);
            }

            return view('artikel.edit', compact('artikel'));
        } catch (\Exception $e) {
            Log::error('Error loading edit data: ' . $e->getMessage());
            return request()->ajax() ? response()->json(['error' => 'Gagal memuat data artikel.'], 500) : redirect()->route('artikel')->with('error', 'Gagal memuat data artikel.');
        }
    }

    // Perbarui artikel
    public function update(Request $request, $id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'id_kategori' => 'nullable|exists:kategori,id',
                'id_siswa' => 'required|exists:siswa,id',
                'jenis' => 'required|in:bebas,resensi_buku,resensi_film,video',
                'status' => 'required|in:draf,menunggu,disetujui,ditolak',
            ]);

            $data = array_merge($validated, [
                'diterbitkan_pada' => $validated['status'] === 'disetujui' ? now() : null,
                'alasan_penolakan' => $validated['status'] === 'ditolak' ? $request->input('alasan_penolakan', null) : null,
            ]);

            if ($request->hasFile('gambar')) {
                if ($artikel->gambar) {
                    Storage::disk('public')->delete($artikel->gambar);
                }
                $gambarPath = $request->file('gambar')->store('artikel', 'public');
                if ($gambarPath) {
                    $data['gambar'] = $gambarPath;
                    Log::info('Gambar diperbarui untuk artikel ID ' . $id . ': ' . $gambarPath);
                } else {
                    Log::error('Gagal menyimpan gambar untuk artikel ID ' . $id . '. File: ' . $request->file('gambar')->getClientOriginalName());
                }
            }

            $artikel->update($data);
            Log::info('Artikel diperbarui dengan ID: ' . $id . ', Gambar: ' . ($data['gambar'] ?? $artikel->gambar));

            return redirect()->route('artikel')->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui artikel.');
        }
    }

    // Hapus artikel (soft delete)
    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $artikel->delete(); // Soft delete default

            return redirect()->route('artikel')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal menghapus artikel.');
        }
    }

    // Tampilkan detail artikel (halaman terpisah)
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

    // Export data artikel ke CSV
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
                        strip_tags($artikel->isi), // Menghapus HTML tags dari isi
                        $artikel->kategori->nama ?? 'Tanpa Kategori',
                        $artikel->siswa->nama ?? 'Unknown',
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
}