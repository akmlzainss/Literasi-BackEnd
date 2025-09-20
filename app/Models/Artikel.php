<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
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
        'riwayat_persetujuan' => 'array', // bisa juga 'json', keduanya setara
        'jumlah_dilihat'      => 'integer'
    ];

    /* =====================
     |   ACCESSORS
     ===================== */

    // URL gambar (untuk API/WEB)
    public function getGambarUrlAttribute()
    {
        return $this->gambar ? Storage::url($this->gambar) : null;
    }

    // Nama penulis dinamis
    public function getPenulisNamaAttribute()
    {
        if ($this->penulis_type === 'siswa' && $this->siswa) {
            return $this->siswa->nama;
        }
        return 'Admin';
    }

    // Rata-rata rating
    public function getRatingAttribute()
    {
        return $this->ratingArtikel()->avg('rating') ?? 0;
    }

    // Jumlah review
    public function getTotalReviewsAttribute()
    {
        return $this->ratingArtikel()->count();
    }

    /* =====================
     |   RELASI
     ===================== */

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_artikel', 'id');
    }

    public function ratingArtikel()
    {
        return $this->hasMany(RatingArtikel::class, 'id_artikel', 'id');
    }

    public function interaksis()
{
    return $this->hasMany(InteraksiArtikel::class, 'id_artikel');
}

    /* =====================
     |   SCOPES (untuk API)
     ===================== */

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%$search%")
              ->orWhere('isi', 'like', "%$search%");
        });
    }

    public function scopeApplyFilter($query, $filter)
    {
        if (!$filter) return $query;

        switch ($filter) {
            case 'published':
                return $query->where('status', 'disetujui')->whereNotNull('diterbitkan_pada');
            case 'draft':
                return $query->where('status', 'draf');
            case 'archived':
                return $query->where('status', 'ditolak')->orWhereNotNull('deleted_at');
            case 'most_viewed':
                return $query->orderBy('jumlah_dilihat', 'desc');
            case 'least_viewed':
                return $query->orderBy('jumlah_dilihat', 'asc');
            case 'newest':
                return $query->orderBy('created_at', 'desc');
            case 'oldest':
                return $query->orderBy('created_at', 'asc');
            default:
                return $query->whereHas('kategori', function ($q) use ($filter) {
                    $q->where('nama', $filter);
                });
        }
    }
}
