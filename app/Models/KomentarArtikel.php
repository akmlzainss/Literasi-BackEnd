<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarArtikel extends Model
{
    protected $table = 'komentar_artikel';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_artikel',       // Foreign key ke tabel artikel
        'id_siswa',         // Foreign key ke tabel siswa
        'id_komentar_parent', // Untuk nested comment
        'depth',            // Tingkat kedalaman komentar
        'komentar',         // Isi komentar
    ];

    // Aktifkan timestamps dan gunakan dibuat_pada sebagai created_at
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null; // Nonaktifkan updated_at jika tidak ada kolom ini

    /* =====================
     |   RELASI
     ===================== */

    // Relasi ke artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel', 'id');
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    // Relasi ke komentar parent (nested comment)
    public function parentKomentar()
    {
        return $this->belongsTo(KomentarArtikel::class, 'id_komentar_parent', 'id');
    }

    // Relasi ke balasan komentar
    public function replies()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_komentar_parent', 'id');
    }
}