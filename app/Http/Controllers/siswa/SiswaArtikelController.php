<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\KomentarArtikel;
use App\Models\RatingArtikel;
use App\Models\InteraksiArtikel;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL; // Import URL Facade
use Illuminate\Validation\Rule;

class SiswaArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::query()->where('status', 'disetujui');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort == 'terlama') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort == 'populer') {
            $query->orderBy('jumlah_dilihat', 'desc');
        } else {
            $query->latest();
        }

        $artikels = $query->with(['siswa', 'kategori'])->paginate(12);
        return view('siswa-web-artikel.artikel', compact('artikels'));
    }

    public function show($id)
    {
        // === PERBAIKAN UNTUK TOMBOL KEMBALI ===
        $previousUrl = URL::previous();
        // Simpan URL sebelumnya ke session HANYA JIKA BUKAN halaman detail itu sendiri
        if (!str_contains($previousUrl, '/artikel-siswa/' . $id)) {
            session(['previous_artikel_url' => $previousUrl]);
        }
        // ======================================

        $siswaId = Auth::guard('siswa')->id();
        $konten = Artikel::with([
            'siswa', 'kategori', 'ratingArtikel',
            'komentarArtikel' => function($query) {
                $query->whereNull('id_komentar_parent')->with('siswa', 'admin', 'replies.siswa', 'replies.admin')->latest();
            }
        ])->findOrFail($id);
        
        $userRating = RatingArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->first();
        $userHasLiked = InteraksiArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->where('jenis', 'suka')->exists();
        $userHasBookmarked = InteraksiArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->where('jenis', 'bookmark')->exists();

        if (Auth::guard('siswa')->check() && $konten->id_siswa != $siswaId) {
            $konten->increment('jumlah_dilihat');
        } elseif (!Auth::guard('siswa')->check()){
             $konten->increment('jumlah_dilihat');
        }
        
        return view('siswa-web-artikel.artikel-detail', compact('konten', 'userRating', 'userHasLiked', 'userHasBookmarked'));
    }
    
    public function showUploadChoice()
    {
        return view('siswa-web-artikel.upload-choice');
    }

    public function createArtikel()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('siswa-web-artikel.create-artikel', compact('kategoris'));
    }

    public function storeArtikel(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|min:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kategori' => 'required_without:usulan_kategori|nullable|exists:kategori,id',
            'usulan_kategori' => [
                'required_without:id_kategori', 'nullable', 'string', 'max:50',
                Rule::unique('kategori', 'nama'),
            ],
            'jenis' => 'required|in:bebas,resensi_buku,resensi_film',
        ]);

        $idSiswa = Auth::guard('siswa')->id();
        $idKategori = $request->id_kategori;

        if ($request->filled('usulan_kategori')) {
            $kategoriBaru = Kategori::create([
                'nama' => $request->usulan_kategori,
                'deskripsi' => 'Kategori ini diusulkan oleh siswa.',
                'status' => 'menunggu'
            ]);
            $idKategori = $kategoriBaru->id;
        }

        $gambarPath = $request->hasFile('gambar') ? $request->file('gambar')->store('artikel', 'public') : null;

        Artikel::create([
            'id_siswa' => $idSiswa,
            'id_kategori' => $idKategori,
            'usulan_kategori' => $request->filled('usulan_kategori') ? $request->usulan_kategori : null,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'penulis_type' => 'siswa',
            'jenis' => $request->jenis,
            'status' => 'menunggu',
        ]);
        
        return redirect()->route('artikel-siswa.index')->with('success', 'Artikel berhasil dikirim dan sedang menunggu persetujuan admin!');
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'nullable|string|max:2000',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        $siswaId = Auth::guard('siswa')->id();
        $artikel = Artikel::findOrFail($id);
        $newKomentar = null;

        if ($request->filled('rating')) {
            RatingArtikel::updateOrCreate(
                ['id_artikel' => $artikel->id, 'id_siswa' => $siswaId],
                ['rating' => $request->rating]
            );
        }

        if ($request->filled('komentar')) {
            $newKomentar = KomentarArtikel::create([
                'id_artikel' => $artikel->id,
                'id_siswa'   => $siswaId,
                'komentar'   => $request->komentar,
            ]);
            $newKomentar->load('siswa');
        }
        
        $artikel->nilai_rata_rata = $artikel->ratingArtikel()->avg('rating');
        $artikel->save();

        if ($request->ajax()) {
            $data = [
                'success' => true,
                'new_avg_rating' => round($artikel->nilai_rata_rata, 1),
                'new_rating_count' => $artikel->ratingArtikel->count(),
                'new_comment_count' => $artikel->komentarArtikel->count(),
            ];

            if ($newKomentar) {
                $data['new_comment_html'] = view('partials.komentar', ['komentar' => $newKomentar])->render();
            }
            return response()->json($data);
        }

        return back()->with('success', 'Terima kasih atas tanggapan Anda!');
    }
    
    public function storeInteraksi(Request $request, $id)
    {
        $request->validate(['jenis' => 'required|in:suka,bookmark']);

        $siswaId = Auth::guard('siswa')->id();
        $jenis = $request->jenis;
        $artikel = Artikel::findOrFail($id);

        $interaksi = InteraksiArtikel::where('id_artikel', $id)
            ->where('id_siswa', $siswaId)
            ->where('jenis', $jenis)->first();

        if ($interaksi) {
            $interaksi->delete();
        } else {
            InteraksiArtikel::create(['id_artikel' => $id, 'id_siswa' => $siswaId, 'jenis' => $jenis]);

            if ($jenis == 'suka' && $artikel->id_siswa && $artikel->id_siswa != $siswaId) {
                Notifikasi::create([
                    'id_siswa' => $artikel->id_siswa,
                    'judul' => 'Artikel Anda Disukai',
                    'pesan' => Auth::guard('siswa')->user()->nama . ' menyukai artikel Anda: "' . $artikel->judul . '".',
                    'jenis' => 'like',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $artikel->id,
                ]);
            }
        }
        
        $artikel->jumlah_suka = $artikel->interaksis()->where('jenis', 'suka')->count();
        $artikel->save();

        return response()->json([
            'success' => true,
            'like_count' => $artikel->jumlah_suka
        ]);
    }
}