<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'artikel';

    /**
     * AKTIFKAN timestamps agar Laravel mengelola created_at & updated_at.
     * @var bool
     */
    public $timestamps = true;

    /**
     * Hapus 'dibuat_pada' dari fillable karena sudah dihandle otomatis.
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
    ];

    /**
     * Sesuaikan casts untuk kolom tanggal yang baru.
     */
    protected $casts = [
        'diterbitkan_pada' => 'datetime',
        'created_at' => 'datetime', // Ganti dari dibuat_pada
        'updated_at' => 'datetime', // Tambahkan updated_at
        'deleted_at' => 'datetime',
        'riwayat_persetujuan' => 'json', // Pastikan kolom json di-cast
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

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function komentarArtikel()
    {
        // Ganti nama relasi agar konsisten (opsional tapi disarankan)
        return $this->hasMany(KomentarArtikel::class, 'id_artikel');
    }

    // ... Relasi lainnya biarkan seperti semula ...

    //======================================================================
    // SCOPES
    //======================================================================

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('judul', 'like', "%{$search}%")
                         ->orWhere('isi', 'like', "%{$search}%");
        }
        return $query;
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
                return $query->orderBy('created_at', 'desc'); // PERBAIKAN
            case 'oldest':
                return $query->orderBy('created_at', 'asc'); // PERBAIKAN
            default:
                return $query->whereHas('kategori', function ($q) use ($filter) {
                    $q->where('nama', $filter);
                });
        }
    }
}