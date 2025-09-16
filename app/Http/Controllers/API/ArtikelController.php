<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use App\Models\KomentarArtikel;
use App\Models\Notifikasi;

class ArtikelController extends Controller
{
    /**
     * Mengambil SEMUA artikel yang sudah disetujui untuk timeline home.
     */
    public function index()
    {
        $artikels = Artikel::where('status', 'disetujui')
            ->with(['siswa:id,nama', 'kategori:id,nama']) // Eager load relasi & hanya ambil kolom yg perlu
            ->latest() // Urutkan dari yang terbaru
            ->paginate(15); // Batasi 15 artikel per halaman

        return response()->json($artikels);
    }

    /**
     * Mengambil artikel milik siswa yang sedang login (untuk halaman profil).
     */
    public function myArticles(Request $request)
    {
        $siswa = $request->user();

        $artikels = Artikel::where('id_siswa', $siswa->id)
            ->with('kategori:id,nama')
            ->latest()
            ->get();

        return response()->json($artikels);
    }

    /**
     * Menyimpan artikel baru yang diunggah oleh siswa.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:5000',
            'id_kategori' => 'nullable|exists:kategori,id',
            'jenis' => 'required|in:bebas,resensi_buku,resensi_film,video',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $siswa = $request->user();
        $data = $validator->validated();
        $data['isi'] = Purifier::clean($data['isi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $data['id_siswa'] = $siswa->id;
        $data['penulis_type'] = 'siswa';
        $data['status'] = 'menunggu';

        $artikel = Artikel::create($data);

        return response()->json([
            'message' => 'Artikel berhasil diunggah dan sedang menunggu persetujuan.',
            'data' => $artikel
        ], 201);
    }

    /**
     * Menyimpan komentar baru pada artikel tertentu.
     */
    public function storeComment(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id); // Cari artikel berdasarkan ID
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $siswa = $request->user();
        $komentar = KomentarArtikel::create([
            'id_artikel' => $artikel->id,
            'id_siswa' => $siswa->id,
            'komentar' => $request->komentar,
        ]);

        if ($artikel->id_siswa !== $siswa->id) {
            Notifikasi::create([
                'id_siswa' => $artikel->id_siswa,
                'judul' => 'Komentar Baru di Artikel Anda!',
                'pesan' => "{$siswa->nama} mengomentari artikel Anda \"{$artikel->judul}\".",
                'jenis' => 'comment',
                'referensi_tipe' => 'artikel',
                'referensi_id' => $artikel->id,
            ]);
        }

        return response()->json(['message' => 'Komentar berhasil ditambahkan.', 'data' => $komentar], 201);
    }

    /**
     * Mengambil daftar komentar untuk artikel tertentu.
     */
    public function indexComments(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id); // Cari artikel berdasarkan ID
        $komentar = $artikel->komentarArtikel()
            ->with('siswa:id,nama')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_siswa' => $item->siswa->nama,
                    'komentar' => $item->komentar,
                    'dibuat_pada' => $item->dibuat_pada ? $item->dibuat_pada->toIso8601String() : null,
                ];
            });

        return response()->json(['data' => $komentar], 200);
    }
}