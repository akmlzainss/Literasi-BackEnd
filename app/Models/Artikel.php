<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terhubung dengan model.
     * @var string
     */
    protected $table = 'artikel';

    /**
     * Menonaktifkan timestamp otomatis 'created_at' dan 'updated_at' dari Laravel.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
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
        'dibuat_pada'
    ];

    /**
     * Mengubah tipe data atribut secara otomatis saat diakses.
     * Ini adalah cara modern untuk menangani kolom tanggal dan akan memperbaiki error.
     * @var array<string, string>
     */
    protected $casts = [
        'dibuat_pada'      => 'datetime',
        'diterbitkan_pada' => 'datetime',
        'deleted_at'       => 'datetime',
    ];

    //======================================================================
    // ACCESSORS
    //======================================================================

    /**
     * Accessor untuk mendapatkan nama penulis secara dinamis.
     * Di view, panggil dengan: {{ $artikel->penulis_nama }}
     * @return string
     */
    public function getPenulisNamaAttribute()
    {
        if ($this->penulis_type === 'siswa' && $this->siswa) {
            return $this->siswa->nama;
        }
        return 'Admin';
    }

    //======================================================================
    // RELATIONS
    //======================================================================

    /**
     * Mendefinisikan relasi "belongsTo" ke model Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model RatingArtikel.
     */
    public function RatingArtikel()
    {
        return $this->hasMany(RatingArtikel::class, 'id_artikel');
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model InteraksiArtikel.
     */
    public function interaksiArtikel()
    {
        return $this->hasMany(InteraksiArtikel::class, 'id_artikel');
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model KomentarArtikel.
     */
    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_artikel');
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model MediaArtikel.
     */
    public function mediaArtikel()
    {
        return $this->hasMany(MediaArtikel::class, 'id_artikel');
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model Penghargaan.
     */
    public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class, 'id_artikel');
    }

    //======================================================================
    // SCOPES
    //======================================================================

    /**
     * Local scope untuk pencarian berdasarkan judul atau isi.
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('judul', 'like', "%{$search}%")
                         ->orWhere('isi', 'like', "%{$search}%");
        }
        return $query;
    }

    /**
     * Local scope untuk menerapkan filter.
     */
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
                return $query->orderBy('dibuat_pada', 'desc');
            case 'oldest':
                return $query->orderBy('dibuat_pada', 'asc');
            default:
                return $query->whereHas('kategori', function ($q) use ($filter) {
                    $q->where('nama', $filter);
                });
        }
    }
}