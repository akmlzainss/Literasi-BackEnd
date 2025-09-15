<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\InteraksiArtikel;
use App\Models\RatingArtikel;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class InteraksiController extends Controller
{
    public function toggleInteraksi(Request $request, Artikel $artikel)
    {
        $request->validate(['jenis' => 'required|in:suka,bookmark']);
        
        $siswa = $request->user();
        $jenis = $request->jenis;

        $interaksi = InteraksiArtikel::where('id_artikel', $artikel->id)
            ->where('id_siswa', $siswa->id)
            ->where('jenis', $jenis)
            ->first();

        if ($interaksi) {
            $interaksi->delete();
            return response()->json(['message' => ucfirst($jenis) . ' dihapus.']);
        } 
        
        InteraksiArtikel::create([
            'id_artikel' => $artikel->id,
            'id_siswa' => $siswa->id,
            'jenis' => $jenis,
        ]);

        if ($artikel->id_siswa !== $siswa->id && $jenis === 'suka') {
            Notifikasi::create([
                'id_siswa' => $artikel->id_siswa,
                'judul' => 'Artikel Anda disukai!',
                'pesan' => "{$siswa->nama} menyukai artikel Anda \"{$artikel->judul}\".",
                'jenis' => 'like',
                'referensi_tipe' => 'artikel',
                'referensi_id' => $artikel->id,
            ]);
        }
        
        return response()->json(['message' => 'Artikel berhasil di-' . $jenis . '.']);
    }

    public function beriRating(Request $request, Artikel $artikel)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        $siswa = $request->user();

        RatingArtikel::updateOrCreate(
            ['id_artikel' => $artikel->id, 'id_siswa' => $siswa->id],
            ['rating' => $request->rating]
        );
        
        if ($artikel->id_siswa !== $siswa->id) {
            Notifikasi::create([
                'id_siswa' => $artikel->id_siswa,
                'judul' => 'Artikel Anda diberi rating!',
                'pesan' => "{$siswa->nama} memberikan rating {$request->rating} untuk artikel Anda.",
                'jenis' => 'rating',
                'referensi_tipe' => 'artikel',
                'referensi_id' => $artikel->id,
            ]);
        }
        
        return response()->json(['message' => 'Rating berhasil diberikan.']);
    }

    public function getInteractedArticles(Request $request)
    {
        $request->validate(['jenis' => 'required|in:suka,bookmark']);
        $siswa = $request->user();
        
        $artikelIds = InteraksiArtikel::where('id_siswa', $siswa->id)
            ->where('jenis', $request->jenis)
            ->pluck('id_artikel');
            
        $artikels = Artikel::whereIn('id', $artikelIds)
            ->with(['siswa:id,nama', 'kategori:id,nama'])
            ->latest()
            ->get();
            
        return response()->json($artikels);
    }
}