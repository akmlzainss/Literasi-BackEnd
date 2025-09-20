<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KomentarArtikel;
use App\Models\RatingArtikel;
use App\Models\InteraksiArtikel;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $siswaId = Auth::guard('siswa')->id();
        $konten = Artikel::with([
            'siswa', 'kategori', 'ratingArtikel',
            'komentarArtikel' => function($query) {
                $query->whereNull('id_komentar_parent')->with('siswa', 'replies.siswa')->latest();
            }
        ])->findOrFail($id);
        
        $userRating = RatingArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->first();
        $userHasLiked = InteraksiArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->where('jenis', 'suka')->exists();
        $userHasBookmarked = InteraksiArtikel::where('id_artikel', $id)->where('id_siswa', $siswaId)->where('jenis', 'bookmark')->exists();

        $konten->increment('jumlah_dilihat');
        
        return view('siswa-web-artikel.artikel-detail', compact('konten', 'userRating', 'userHasLiked', 'userHasBookmarked'));
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

        $toggled = false;
        if ($interaksi) {
            $interaksi->delete();
        } else {
            InteraksiArtikel::create(['id_artikel' => $id, 'id_siswa' => $siswaId, 'jenis' => $jenis]);
            $toggled = true;

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
            'toggled' => $toggled,
            'like_count' => $artikel->jumlah_suka
        ]);
    }
}