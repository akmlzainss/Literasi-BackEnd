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
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SiswaArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::query()->where('status', 'disetujui');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
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
        return view('siswa.artikel.artikel', compact('artikels'));
    }

    public function show($id)
    {
        $previousUrl = URL::previous();
        if (!str_contains($previousUrl, '/artikel-siswa/' . $id)) {
            session(['previous_artikel_url' => $previousUrl]);
        }

        $siswaId = Auth::guard('siswa')->id();
        $konten = Artikel::with([
            'siswa',
            'kategori',
            'ratingArtikel',
            // Instagram style: Load only parent comments, then flatten all replies in view
            'komentarArtikel' => function ($query) {
                $query->whereNull('id_komentar_parent') // Only parent comments
                    ->with([
                        'siswa', 
                        'admin',
                        // Eager load replies recursively with parent info for @mention
                        'replies' => function ($q) {
                            $q->with(['siswa', 'admin', 'parent.siswa', 'parent.admin', 'replies' => function ($q2) {
                                $q2->with(['siswa', 'admin', 'parent.siswa', 'parent.admin', 'replies' => function ($q3) {
                                    $q3->with(['siswa', 'admin', 'parent.siswa', 'parent.admin']);
                                }]);
                            }]);
                        }
                    ])
                    ->orderBy('dibuat_pada', 'desc');
            }
        ])->findOrFail($id);

        if (Auth::guard('siswa')->check()) {
            $sessionKey = 'viewed_article_' . $id;
            if ($konten->id_siswa != $siswaId && !session()->has($sessionKey)) {
                $konten->increment('jumlah_dilihat');
                session([$sessionKey => true]);
            }
        } else {
            $sessionKey = 'viewed_article_' . $id;
            if (!session()->has($sessionKey)) {
                $konten->increment('jumlah_dilihat');
                session([$sessionKey => true]);
            }
        }

        // Only query user-specific data if authenticated
        $userRating = null;
        $userHasLiked = false;
        $userHasBookmarked = false;
        
        if ($siswaId) {
            $userRating = RatingArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->first();
            $userHasLiked = InteraksiArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->where('jenis', 'suka')->exists();
            $userHasBookmarked = InteraksiArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->where('jenis', 'bookmark')->exists();
        }

        return view('siswa.artikel.artikel-detail', compact('konten', 'userRating', 'userHasLiked', 'userHasBookmarked'));
    }

    public function showUploadChoice()
    {
        return view('siswa.artikel.upload-choice');
    }

    public function createArtikel()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('siswa.artikel.create-artikel', compact('kategoris'));
    }

    public function storeArtikel(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string|min:100',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_kategori' => 'required_without:usulan_kategori|nullable|exists:kategori,id',
                'usulan_kategori' => [
                    'required_without:id_kategori',
                    'nullable',
                    'string',
                    'max:50',
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

            $artikel = Artikel::create([
                'id_siswa' => $idSiswa,
                'id_kategori' => $idKategori,
                'usulan_kategori' => $request->filled('usulan_kategori') ? $request->usulan_kategori : null,
                'judul' => $request->judul,
                'isi' => strip_tags($request->isi, '<p><br><strong><em><ul><ol><li><h1><h2><h3><a>'),
                'gambar' => $gambarPath,
                'penulis_type' => 'siswa',
                'jenis' => $request->jenis,
                'status' => 'menunggu',
            ]);

            Notifikasi::create([
                'id_siswa' => $idSiswa,
                'judul' => 'Artikel Dikirim untuk Review',
                'pesan' => 'Artikel "' . $request->judul . '" telah dikirim dan sedang menunggu persetujuan admin.',
                'jenis' => 'artikel',
                'referensi_tipe' => 'artikel',
                'referensi_id' => $artikel->id,
            ]);

            return redirect()->route('artikel-siswa.index')->with('success', 'Artikel berhasil dikirim dan sedang menunggu persetujuan admin!');
        } catch (\Exception $e) {
            \Log::error('Error storing artikel: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan artikel. Silakan coba lagi.');
        }
    }

    public function storeKomentar(Request $request, $id, $parentId = null)
    {
        try {
            // Check if user is authenticated first
            if (!Auth::guard('siswa')->check()) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Anda harus login untuk berkomentar.'], 401);
                }
                return redirect()->route('siswa.login')->with('error', 'Anda harus login untuk berkomentar.');
            }

            $request->validate([
                'komentar' => 'nullable|string|max:2000',
                'rating' => 'nullable|integer|between:1,5',
            ]);

            if (!$request->filled('komentar') && !$request->filled('rating')) {
                return response()->json(['success' => false, 'message' => 'Harus memberikan rating atau komentar.'], 400);
            }

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
                    'id_siswa' => $siswaId,
                    'id_komentar_parent' => $parentId,
                    'komentar' => strip_tags($request->komentar, '<p><br><strong><em>'),
                ]);
                $newKomentar->load('siswa', 'replies');
            }

            $artikel->nilai_rata_rata = $artikel->ratingArtikel()->avg('rating') ?: 0;
            $artikel->save();

            if ($request->ajax()) {
                $data = [
                    'success' => true,
                    'new_avg_rating' => round($artikel->nilai_rata_rata, 1),
                    'new_rating_count' => $artikel->ratingArtikel->count(),
                    'new_comment_count' => $artikel->komentarArtikel->count(),
                ];

                if ($newKomentar) {
                    $data['new_comment_html'] = view('partials.komentar', ['komentar' => $newKomentar, 'konten' => $artikel])->render();
                }
                return response()->json($data);
            }

            return back()->with('success', 'Terima kasih atas tanggapan Anda!')->with('previous_artikel_url', route('artikel-siswa.show', $id));
        } catch (\Exception $e) {
            \Log::error('Error storing komentar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan komentar.'], 500);
        }
    }

    public function destroyKomentar($id)
    {
        try {
            if (!Auth::guard('siswa')->check() && !Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
                return response()->json(['success' => false, 'message' => 'Anda harus login untuk menghapus komentar.'], 401);
            }

            $komentar = KomentarArtikel::findOrFail($id);

            $bolehHapus =
                (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) ||
                Auth::guard('admin')->check() ||
                Auth::guard('web')->check();

            if (!$bolehHapus) {
                return response()->json(['success' => false, 'message' => 'Anda tidak berhak menghapus komentar ini.'], 403);
            }

            // Hapus semua balasan secara rekursif
            $komentar->replies()->delete();
            $komentar->delete();

            return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting komentar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus komentar.'], 500);
        }
    }

    public function storeRating(Request $request, $id)
    {
        try {
            // Check if user is authenticated first
            if (!Auth::guard('siswa')->check()) {
                return response()->json(['success' => false, 'message' => 'Anda harus login untuk memberi rating.'], 401);
            }

            $request->validate([
                'rating' => 'required|integer|between:1,5',
            ]);

            $siswaId = Auth::guard('siswa')->id();
            $artikel = Artikel::findOrFail($id);

            RatingArtikel::updateOrCreate(
                ['id_artikel' => $artikel->id, 'id_siswa' => $siswaId],
                ['rating' => $request->rating]
            );

            $artikel->nilai_rata_rata = $artikel->ratingArtikel()->avg('rating') ?: 0;
            $artikel->save();

            return response()->json([
                'success' => true,
                'new_avg_rating' => round($artikel->nilai_rata_rata, 1),
                'new_rating_count' => $artikel->ratingArtikel->count(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error storing rating: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan rating.'], 500);
        }
    }

    public function storeInteraksi(Request $request, $id)
    {
        try {
            // Check if user is authenticated first
            if (!Auth::guard('siswa')->check()) {
                return response()->json(['success' => false, 'message' => 'Anda harus login untuk menyukai atau menyimpan artikel.'], 401);
            }

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
                $interaksi = InteraksiArtikel::create(['id_artikel' => $id, 'id_siswa' => $siswaId, 'jenis' => $jenis]);

                if ($jenis == 'suka' && $artikel->siswa_id && $artikel->siswa_id != $siswaId) {
                    Notifikasi::create([
                        'id_siswa' => $artikel->siswa_id,
                        'judul' => 'Artikel Anda Disukai',
                        'pesan' => Auth::guard('siswa')->user()->nama . ' menyukai artikel Anda: "' . $artikel->judul . '".',
                        'jenis' => 'like',
                        'referensi_tipe' => 'artikel',
                        'referensi_id' => $artikel->id,
                    ]);
                }
            }

            $artikel->jumlah_suka = $artikel->interaksi()->where('jenis', 'suka')->count();
            $artikel->save();

            return response()->json([
                'success' => true,
                'like_count' => $artikel->jumlah_suka
            ]);
        } catch (\Exception $e) {
            \Log::error('Error storing interaksi: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan interaksi.'], 500);
        }
    }
}
