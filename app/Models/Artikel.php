<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'artikel';
    public $timestamps = true;

    protected $fillable = [
        'id_siswa',
        'id_kategori',
        'judul',
        'isi',
        'gambar',
        'penulis_type',
        'jenis',
        'status',
        'alasan_penolakan',
        'diterbitkan_pada',
        'jumlah_dilihat',
        'jumlah_suka',
        'nilai_rata_rata',
        'riwayat_persetujuan',
        'usulan_kategori',
    ];

    protected $casts = [
        'diterbitkan_pada'    => 'datetime',
        'created_at'          => 'datetime',
        'updated_at'          => 'datetime',
        'deleted_at'          => 'datetime',
        'riwayat_persetujuan' => 'array',
    ];

    /* =====================
     |   RELASI
     ===================== */

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    // Relasi ke tabel kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    // Relasi ke komentar artikel
    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'artikel_id', 'id');
    }

    // Relasi ke rating artikel
    public function ratingArtikel()
    {
        return $this->hasMany(RatingArtikel::class, 'id_artikel', 'id');
    }

    /* =====================
     |   ACCESSORS
     ===================== */

    // Hitung rata-rata rating artikel
    public function getRatingAttribute()
    {
        return $this->ratingArtikel()->avg('rating') ?? 0;
    }

    // Hitung jumlah review artikel
    public function getTotalReviewsAttribute()
    {
        return $this->ratingArtikel()->count();
    }
}
