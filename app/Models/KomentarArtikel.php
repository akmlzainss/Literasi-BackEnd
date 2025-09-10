<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarArtikel extends Model
{
    protected $table = 'komentar_artikel';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'artikel_id',       // ✅ harus artikel_id sesuai tabel
        'id_siswa',
        'id_komentar_parent',
        'depth',
        'komentar',
        'dibuat_pada',
    ];

    /* =====================
     |   RELASI
     ===================== */

    // Relasi ke artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id', 'id');
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
