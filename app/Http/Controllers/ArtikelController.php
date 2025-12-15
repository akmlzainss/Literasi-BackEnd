<?php

namespace App\Http\Controllers;

use App\Exports\BackupAllExport;
use App\Models\Siswa;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\LogAdmin;
use App\Models\RatingArtikel;
use App\Models\KomentarArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin,siswa')->only(['index', 'show', 'rate']);
        $this->middleware('auth:admin')->only(['create', 'store', 'edit', 'update', 'destroy', 'status']);
    }

    public function index(Request $request)
    {
        $query = Artikel::with(['kategori', 'siswa'])->latest();

        if ($search = $request->query('search')) {
            $query->where('judul', 'LIKE', "%{$search}%")
                ->orWhere('isi', 'LIKE', "%{$search}%");
        }
        if ($kategori = $request->query('kategori')) {
            $query->whereHas('kategori', function ($q) use ($kategori) {
                $q->where('nama', $kategori);
            });
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $artikels = $query->paginate(10)->appends($request->query());

        return view('artikel.artikel', compact('artikels', 'status'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('artikel.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul'        => 'required|string|max:255',
                'isi'          => 'required|string|max:3000',
                'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_kategori'  => 'required|exists:kategori,id',
                'penulis_type' => 'required|in:admin,siswa',
                'id_siswa'     => 'required_if:penulis_type,siswa|nullable|exists:siswa,id',
                'jenis'        => 'required|in:bebas,resensi_buku,resensi_film,video',
                'status'       => 'required|in:draf,menunggu,disetujui,ditolak',
                'alasan_penolakan' => 'nullable|string|required_if:status,ditolak',
                'rating'       => 'nullable|integer|min:1|max:5',
            ]);

            // Tentukan id_siswa berdasarkan penulis_type
            $idSiswa = null;
            if ($request->penulis_type === 'siswa') {
                if (empty($request->id_siswa)) {
                    return response()->json([
                        'message' => 'Validasi gagal.',
                        'errors' => ['id_siswa' => ['Siswa penulis harus dipilih untuk penulis siswa.']]
                    ], 422);
                }
                $idSiswa = $request->id_siswa;
            }
            // Jika admin, id_siswa tetap null

            $gambarPath = $request->hasFile('gambar') ? $request->file('gambar')->store('artikel', 'public') : null;

            $artikel = Artikel::create([
                'id_siswa'        => $idSiswa, // null untuk admin, id siswa untuk siswa
                'id_kategori'     => $validated['id_kategori'],
                'judul'           => $validated['judul'],
                'gambar'          => $gambarPath,
                'isi'             => $validated['isi'],
                'penulis_type'    => $validated['penulis_type'],
                'jenis'           => $validated['jenis'],
                'status'          => $validated['status'],
                'alasan_penolakan' => $validated['status'] === 'ditolak' ? $validated['alasan_penolakan'] : null,
                'nilai_rata_rata' => $validated['rating'] ?? 0,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            if ($request->filled('rating') && $idSiswa) {
                $this->saveRating($artikel->id, $idSiswa, $validated['rating']);
            }

            $this->logAction('create', 'Menambahkan artikel baru', 'artikel', $artikel->id);

            return response()->json([
                'message' => 'Artikel berhasil dibuat!', 
                'redirect' => route('admin.artikel.index')
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->logFailedAction('gagal_create', 'Gagal menambahkan artikel', 'artikel', [
                'error' => $e->getMessage(),
                'errors' => $e->errors()
            ]);
            return response()->json([
                'message' => 'Validasi gagal.', 
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            $this->logFailedAction('gagal_create', 'Gagal menambahkan artikel', 'artikel', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Gagal menambahkan artikel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            if (!Auth::guard('admin')->check()) {
                return response()->json([
                    'message' => 'Hanya admin yang dapat menghapus artikel.'
                ], 403);
            }

            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            $artikel->delete();

            $this->logAction('delete', 'Menghapus artikel', 'artikel', $id);

            return response()->json([
                'message' => 'Artikel berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting article: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menghapus artikel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $artikel = Artikel::with([
            'siswa',
            'kategori',
            'ratingArtikel',
            'komentarArtikel.siswa',
            'komentarArtikel.admin',
            'komentarArtikel.replies',
        ])->findOrFail($id);

        $artikel->diterbitkan_pada = $artikel->diterbitkan_pada
            ? \Carbon\Carbon::parse($artikel->diterbitkan_pada)
            : null;

        $avgRating = $artikel->ratingArtikel->avg('rating') ?? 0;

        return view('artikel.show', compact('artikel', 'avgRating'));
    }

    public function storeComment(Request $request, $artikelId)
    {
        try {
            $validated = $request->validate([
                'komentar' => 'required|string|max:1000',
                'id_komentar_parent' => 'nullable|exists:komentar_artikel,id',
                'depth' => 'nullable|integer|min:0|max:2',
            ]);

            $userId = Auth::guard('admin')->id() ?: Auth::guard('siswa')->id();
            $guard = Auth::guard('admin')->check() ? 'admin' : 'siswa';

            if (!$userId) {
                return redirect()->back()->with('error', 'Hanya admin atau siswa yang dapat berkomentar.');
            }

            $depth = $validated['id_komentar_parent'] ? ($validated['depth'] ?? 0) + 1 : 0;
            if ($depth > 2) {
                return redirect()->back()->with('error', 'Kedalaman komentar maksimum adalah 2 level.');
            }

            $komentar = KomentarArtikel::create([
                'id_artikel' => $artikelId,
                'id_siswa' => $guard === 'siswa' ? $userId : null,
                'id_admin' => $guard === 'admin' ? $userId : null,
                'id_komentar_parent' => $validated['id_komentar_parent'],
                'depth' => $depth,
                'komentar' => $validated['komentar'],
                'dibuat_pada' => now(),
            ]);

            $this->logAdminAction('create_comment', 'Menambahkan komentar', 'komentar_artikel', $komentar->id, [
                'artikel_id' => $artikelId
            ]);

            return redirect()->route($guard === 'admin' ? 'admin.artikel.show' : 'artikel-siswa.show', $artikelId)
                ->with('success', 'Komentar berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            \Log::error('Error saving comment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan komentar: ' . $e->getMessage());
        }
    }

    private function logAdminAction($actionType, $action, $refType, $refId, $details = [])
    {
        $userId = Auth::guard('admin')->id() ?: Auth::guard('siswa')->id();
        $guard = Auth::guard('admin')->check() ? 'admin' : 'siswa';
        
        if ($userId) {
            try {
                // Handle null refId
                $logRefId = $refId ?? 0;
                
                \App\Models\LogAdmin::create([
                    'id_admin' => $guard === 'admin' ? $userId : null,
                    'id_siswa' => $guard === 'siswa' ? $userId : null,
                    'jenis_aksi' => $actionType,
                    'aksi' => $action,
                    'referensi_tipe' => $refType,
                    'referensi_id' => $logRefId,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->header('User-Agent'),
                    'detail' => !empty($details) ? json_encode($details) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save log: ' . $e->getMessage());
            }
        }
    }

    public function updateComment(Request $request, $komentarId)
    {
        try {
            $validated = $request->validate([
                'komentar' => 'required|string|max:1000',
            ]);

            $komentar = KomentarArtikel::findOrFail($komentarId);

            if (!Auth::guard('admin')->check()) {
                return redirect()->back()->with('error', 'Hanya admin yang dapat mengedit komentar.');
            }

            $komentar->update([
                'komentar' => $validated['komentar'],
                'updated_at' => now(),
            ]);

            $this->logAdminAction('update_comment', 'Mengedit komentar', 'komentar_artikel', $komentar->id, [
                'artikel_id' => $komentar->id_artikel
            ]);

            return redirect()->route('admin.artikel.show', $komentar->id_artikel)
                ->with('success', 'Komentar berhasil diperbarui!');
                
        } catch (\Exception $e) {
            \Log::error('Error updating comment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui komentar: ' . $e->getMessage());
        }
    }

    public function status($status)
    {
        $artikels = Artikel::where('status', $status)->with(['kategori', 'siswa'])->paginate(10);
        return view('artikel.artikel', compact('artikels', 'status'));
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $kategoris = Kategori::all();
        return view('artikel.edit', compact('artikel', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'judul'        => 'required|string|max:255',
                'isi'          => 'required|string|max:3000',
                'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_kategori'  => 'required|exists:kategori,id',
                'penulis_type' => 'required|in:admin,siswa',
                'id_siswa'     => 'required_if:penulis_type,siswa|nullable|exists:siswa,id',
                'jenis'        => 'required|in:bebas,resensi_buku,resensi_film,video',
                'status'       => 'required|in:draf,menunggu,disetujui,ditolak',
                'alasan_penolakan' => 'nullable|string|required_if:status,ditolak',
                'rating'       => 'nullable|integer|min:1|max:5',
            ]);

            // Tentukan id_siswa berdasarkan penulis_type
            $idSiswa = null;
            if ($request->penulis_type === 'siswa') {
                if (empty($request->id_siswa)) {
                    return response()->json([
                        'message' => 'Validasi gagal.',
                        'errors' => ['id_siswa' => ['Siswa penulis harus dipilih untuk penulis siswa.']]
                    ], 422);
                }
                $idSiswa = $request->id_siswa;
            }
            // Jika admin, id_siswa tetap null

            $artikel = Artikel::findOrFail($id);

            if ($request->hasFile('gambar')) {
                if ($artikel->gambar) {
                    Storage::disk('public')->delete($artikel->gambar);
                }
                $artikel->gambar = $request->file('gambar')->store('artikel', 'public');
            }

            $artikel->update([
                'id_siswa'         => $idSiswa, // null untuk admin, id siswa untuk siswa
                'id_kategori'      => $validated['id_kategori'],
                'judul'            => $validated['judul'],
                'isi'              => $validated['isi'],
                'penulis_type'     => $validated['penulis_type'],
                'jenis'            => $validated['jenis'],
                'status'           => $validated['status'],
                'alasan_penolakan' => $validated['status'] === 'ditolak' ? $validated['alasan_penolakan'] : null,
                'updated_at'       => now(),
            ]);

            if ($request->filled('rating') && $idSiswa) {
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
                        'updated_at'     => now(),
                    ]);
                } else {
                    $this->saveRating($artikel->id, $idSiswa, $validated['rating']);
                }

                $artikel->nilai_rata_rata = round(RatingArtikel::where('id_artikel', $artikel->id)->avg('rating'), 2);
                $artikel->save();
            }

            $this->logAction('update', 'Mengedit artikel', 'artikel', $artikel->id);

            return response()->json([
                'message' => 'Artikel berhasil diperbarui!', 
                'redirect' => route('admin.artikel.index')
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->logFailedAction('gagal_update', 'Gagal mengedit artikel', 'artikel', [
                'error' => $e->getMessage(),
                'errors' => $e->errors(),
                'artikel_id' => $id
            ]);
            return response()->json([
                'message' => 'Validasi gagal.', 
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            $this->logFailedAction('gagal_update', 'Gagal mengedit artikel', 'artikel', [
                'error' => $e->getMessage(),
                'artikel_id' => $id
            ]);
            return response()->json([
                'message' => 'Gagal memperbarui artikel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyComment($komentarId)
    {
        try {
            $komentar = KomentarArtikel::findOrFail($komentarId);

            if (!Auth::guard('admin')->check()) {
                return response()->json([
                    'message' => 'Hanya admin yang dapat menghapus komentar.'
                ], 403);
            }

            $artikelId = $komentar->id_artikel;
            $komentar->delete();

            $this->logAdminAction('delete_comment', 'Menghapus komentar', 'komentar_artikel', $komentarId, [
                'artikel_id' => $artikelId
            ]);

            return response()->json([
                'message' => 'Komentar berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting comment: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menghapus komentar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function export()
    {
        try {
            $this->logAction('export', 'Mengekspor artikel ke Excel', 'artikel', 0);
            return Excel::download(new BackupAllExport, 'artikel_' . now()->format('Ymd_His') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('Error exporting articles: ' . $e->getMessage());
            $this->logFailedAction('gagal_export', 'Gagal mengekspor artikel', 'artikel', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal mengekspor artikel: ' . $e->getMessage());
        }
    }

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

    public function rate(Request $request, $artikelId)
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $userId = Auth::guard('admin')->id() ?: Auth::guard('siswa')->id();
            $guard = Auth::guard('admin')->check() ? 'admin' : 'siswa';

            if (!$userId) {
                return response()->json([
                    'message' => 'Hanya admin atau siswa yang dapat memberikan rating.'
                ], 403);
            }

            $rating = RatingArtikel::updateOrCreate(
                [
                    'id_artikel' => $artikelId,
                    'id_siswa' => $guard === 'siswa' ? $userId : null,
                    'id_admin' => $guard === 'admin' ? $userId : null,
                ],
                [
                    'rating' => $validated['rating'],
                    'updated_at' => now(),
                ]
            );

            $this->logAdminAction('rate_article', 'Memberikan rating', 'rating_artikel', $rating->id, [
                'artikel_id' => $artikelId
            ]);

            return response()->json([
                'message' => 'Rating berhasil disimpan!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saving rating: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan rating: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getUserId()
    {
        return Auth::guard('admin')->check() ? Auth::guard('admin')->id() : Auth::guard('siswa')->id();
    }

    private function saveRating($artikelId, $siswaId, $rating)
    {
        RatingArtikel::create([
            'id_artikel'     => $artikelId,
            'id_siswa'       => $siswaId,
            'rating'         => $rating,
            'riwayat_rating' => [],
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }

    private function logAction($actionType, $action, $refType, $refId, $details = [])
    {
        $userId = $this->getUserId();
        if ($userId) {
            try {
                // Pastikan referensi_id tidak null
                $logRefId = $refId ?? 0;
                
                LogAdmin::create([
                    'id_admin'       => $userId,
                    'jenis_aksi'     => $actionType,
                    'aksi'           => $action,
                    'referensi_tipe' => $refType,
                    'referensi_id'   => $logRefId,
                    'ip_address'     => request()->ip(),
                    'user_agent'     => request()->header('User-Agent'),
                    'detail'         => !empty($details) ? json_encode($details) : null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save LogAdmin: ' . $e->getMessage(), [
                    'action' => $actionType,
                    'ref_type' => $refType,
                    'ref_id' => $refId,
                ]);
            }
        }
    }

    private function logFailedAction($actionType, $action, $refType, $details = [])
    {
        $userId = $this->getUserId();
        if ($userId) {
            try {
                LogAdmin::create([
                    'id_admin'       => $userId,
                    'jenis_aksi'     => $actionType,
                    'aksi'           => $action,
                    'referensi_tipe' => $refType,
                    'referensi_id'   => 0, // Default value untuk aksi gagal
                    'ip_address'     => request()->ip(),
                    'user_agent'     => request()->header('User-Agent'),
                    'detail'         => !empty($details) ? json_encode($details) : null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save LogAdmin (failed action): ' . $e->getMessage(), [
                    'action' => $actionType,
                    'ref_type' => $refType,
                ]);
            }
        }
    }
}