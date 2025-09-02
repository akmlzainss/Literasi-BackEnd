<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

class ArtikelController extends Controller
{
    /**
     * FUNGSI BARU: Mengambil daftar artikel milik siswa yang sedang login.
     */
    public function index(Request $request)
    {
        // Mengambil user (siswa) yang terautentikasi dari token
        $siswa = $request->user();

        // Mengambil artikel berdasarkan id_siswa, diurutkan dari yang terbaru
        $artikels = Artikel::where('id_siswa', $siswa->id)
            ->with('kategori') // Eager load relasi kategori
            ->latest() // Otomatis urutkan berdasarkan created_at DESC
            ->get();

        return response()->json($artikels);
    }

    /**
     * Menyimpan artikel baru yang diunggah oleh siswa dari Flutter.
     */
    public function store(Request $request)
    {
        // ... (Fungsi store Anda tetap sama)
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
}
