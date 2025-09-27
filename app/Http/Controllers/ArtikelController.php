<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use App\Models\RatingArtikel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('admin')->check() || Auth::guard('siswa')->check()) {
                return $next($request);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        });
    }

    /**
     * Display a listing of articles.
     */
    public function index()
    {
        $artikels = Artikel::with(['kategori', 'siswa'])->latest()->paginate(10);
        return view('artikel.artikel', compact('artikels'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('artikel.create', compact('kategoris'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul'        => 'required|string|max:255',
                'isi'          => 'required|string',
                'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_kategori'  => 'required|exists:kategori,id',
                'penulis_type' => 'required|in:admin,siswa',
                'id_siswa'     => 'required_if:penulis_type,siswa|exists:siswa,id',
                'jenis'        => 'required|in:bebas,resensi_buku,resensi_film,video',
                'status'       => 'required|in:draf,menunggu,disetujui,ditolak',
                'rating'       => 'nullable|integer|min:1|max:5',
            ]);

            $idSiswa = $this->getAuthorId($request);
            $gambarPath = $request->hasFile('gambar') ? $request->file('gambar')->store('artikel', 'public') : null;

            $artikel = Artikel::create([
                'id_siswa'        => $idSiswa,
                'id_kategori'     => $validated['id_kategori'],
                'judul'           => $validated['judul'],
                'gambar'          => $gambarPath,
                'isi'             => $validated['isi'],
                'penulis_type'    => $validated['penulis_type'],
                'jenis'           => $validated['jenis'],
                'status'          => $validated['status'],
                'nilai_rata_rata' => $validated['rating'] ?? 0,
            ]);

            // Save initial rating if provided
            if ($request->filled('rating') && $idSiswa) {
                $this->saveRating($artikel->id, $idSiswa, $validated['rating']);
            }

            $this->logAction('create', 'Menambahkan artikel baru', 'artikel', $artikel->id);

            return redirect()->route('artikel')->with('success', 'Artikel berhasil dibuat!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan artikel. ' . $e->getMessage());
        }
    }
    public function getArtikelById($id)
    {
        // Panggil stored procedure
        $artikel = DB::select('CALL getArtikelById(?)', [$id]);

        // Karena hasil DB::select array, ambil index 0
        $artikel = $artikel[0] ?? null;

        // Kirim ke view
        return view('artikel.detail', compact('artikel'));
    }

    /**
     * Display the specified article.
     */
   public function show($id)
{
    $artikel = Artikel::with([
        'siswa',
        'kategori',
        'ratingArtikel',
        'komentarArtikel.siswa',
        'komentarArtikel.admin',
    ])->findOrFail($id);

    // pastikan diterbitkan_pada berupa Carbon, atau null jika kosong
    $artikel->diterbitkan_pada = $artikel->diterbitkan_pada
        ? \Carbon\Carbon::parse($artikel->diterbitkan_pada)
        : null;

    // hitung rata-rata rating
    $avgRating = $artikel->ratingArtikel->avg('nilai') ?? 0;

    return view('artikel.show', compact('artikel', 'avgRating'));
}

public function status($status)
{
    $artikels = Artikel::where('status', $status)->paginate(10);

    return view('artikel.artikel', [
        'artikels' => $artikels,
        'status'   => $status
    ]);
}


    /**
     * Show the form for editing the specified article.
     */
    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $kategoris = Kategori::all();
        return view('artikel.edit', compact('artikel', 'kategoris'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'judul'        => 'required|string|max:255',
                'isi'          => 'required|string',
                'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_kategori'  => 'required|exists:kategori,id',
                'penulis_type' => 'required|in:admin,siswa',
                'id_siswa'     => 'required_if:penulis_type,siswa|exists:siswa,id',
                'jenis'        => 'required|in:bebas,resensi_buku,resensi_film,video',
                'status'       => 'required|in:draf,menunggu,disetujui,ditolak',
                'alasan_penolakan' => 'nullable|string|required_if:status,ditolak',
                'rating'       => 'nullable|integer|min:1|max:5',
            ]);

            $artikel = Artikel::findOrFail($id);

            // === Handle image upload ===
            if ($request->hasFile('gambar')) {
                if ($artikel->gambar) {
                    Storage::disk('public')->delete($artikel->gambar);
                }
                $artikel->gambar = $request->file('gambar')->store('artikel', 'public');
            }

            // === Update artikel ===
            $artikel->update([
                'id_siswa'         => $validated['penulis_type'] === 'admin' ? null : $validated['id_siswa'],
                'id_kategori'      => $validated['id_kategori'],
                'judul'            => $validated['judul'],
                'isi'              => $validated['isi'],
                'penulis_type'     => $validated['penulis_type'],
                'jenis'            => $validated['jenis'],
                'status'           => $validated['status'],
                'alasan_penolakan' => $validated['status'] === 'ditolak' ? $validated['alasan_penolakan'] : null,
            ]);

            // === Update rating kalau ada input ===
            if ($request->filled('rating')) {
                $idSiswa = $this->getAuthorId($request);
                if ($idSiswa) {
                    // Cek apakah siswa ini sudah punya rating
                    $rating = RatingArtikel::where('id_artikel', $artikel->id)
                        ->where('id_siswa', $idSiswa)
                        ->first();

                    if ($rating) {
                        $riwayat = $rating->riwayat_rating ?? [];
                        $riwayat[] = [
                            'rating' => $rating->rating,
                            'waktu'  => now()->toDateTimeString(),
                        ];

                        $rating->update([
                            'rating'         => $validated['rating'],
                            'riwayat_rating' => $riwayat,
                            'dibuat_pada'    => now(),
                        ]);
                    } else {
                        $this->saveRating($artikel->id, $idSiswa, $validated['rating']);
                    }

                    // Update rata-rata di artikel
                    $artikel->nilai_rata_rata = round(RatingArtikel::where('id_artikel', $artikel->id)->avg('rating'), 2);
                    $artikel->save();
                }
            }

            $this->logAction('update', 'Mengedit artikel', 'artikel', $artikel->id);

            return redirect()->route('artikel')->with('success', 'Artikel berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui artikel.');
        }
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            $this->logAction('delete', 'Menghapus artikel', 'artikel', $artikel->id);
            $artikel->delete();

            return redirect()->route('artikel')->with('success', 'Artikel berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            $this->logAction('gagal_delete', 'Gagal menghapus artikel', 'artikel', $id, ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menghapus artikel.');
        }
    }

    /**
     * Search students for Select2.
     */
    public function searchSiswa(Request $request)
    {
        $term = $request->input('term', '');
        $siswas = Siswa::where('nama', 'LIKE', "%{$term}%")
            ->orWhere('nis', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get()
            ->map(function ($siswa) {
                return [
                    'id'    => $siswa->id,
                    'text'  => "{$siswa->nama} ({$siswa->nis})",
                    'kelas' => $siswa->kelas ?? '-',
                ];
            });

        return response()->json($siswas);
    }

    /**
     * Store or update article rating.
     */
    public function rate(Request $request, $idArtikel)
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $siswaId = Auth::guard('siswa')->id();
            if (!$siswaId) {
                return back()->with('error', 'Hanya siswa yang dapat memberi rating.');
            }

            $rating = RatingArtikel::where('id_artikel', $idArtikel)
                ->where('id_siswa', $siswaId)
                ->first();

            if ($rating) {
                $riwayat = $rating->riwayat_rating ?? [];
                $riwayat[] = [
                    'rating' => $rating->rating,
                    'waktu'  => now()->toDateTimeString(),
                ];

                $rating->update([
                    'rating'         => $validated['rating'],
                    'riwayat_rating' => $riwayat,
                    'dibuat_pada'    => now(),
                ]);
            } else {
                $this->saveRating($idArtikel, $siswaId, $validated['rating']);
            }

            // Update average rating
            $artikel = Artikel::find($idArtikel);
            if ($artikel) {
                $artikel->nilai_rata_rata = round(RatingArtikel::where('id_artikel', $idArtikel)->avg('rating'), 2);
                $artikel->save();
            }

            return back()->with('success', 'Rating berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error saving rating: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan rating. ' . $e->getMessage());
        }
    }

    /**
     * Helper: Get authenticated user ID based on guard.
     */
    private function getUserId()
    {
        return Auth::guard('admin')->check() ? Auth::guard('admin')->id() : Auth::guard('siswa')->id();
    }

    /**
     * Helper: Get author ID based on penulis_type.
     */
    private function getAuthorId(Request $request)
    {
        return $request->penulis_type === 'siswa'
            ? $request->id_siswa
            : (Auth::guard('siswa')->check() ? Auth::guard('siswa')->id() : null);
    }

    /**
     * Helper: Save rating for an article.
     */
    private function saveRating($artikelId, $siswaId, $rating)
    {
        RatingArtikel::create([
            'id_artikel'     => $artikelId,
            'id_siswa'       => $siswaId,
            'rating'         => $rating,
            'riwayat_rating' => [], // array -> otomatis jadi JSON (karena casts di model)
            'dibuat_pada'    => now(),
        ]);
    }

    /**
     * Helper: Log admin actions.
     */
    private function logAction($actionType, $action, $refType, $refId, $details = [])
    {
        $userId = $this->getUserId();
        if ($userId) {
            LogAdmin::create([
                'id_admin'       => $userId,
                'jenis_aksi'     => $actionType,
                'aksi'           => $action,
                'referensi_tipe' => $refType,
                'referensi_id'   => $refId,
                'detail'         => !empty($details) ? json_encode($details) : null,
                'dibuat_pada'    => now(),
            ]);
        }
    }
}
