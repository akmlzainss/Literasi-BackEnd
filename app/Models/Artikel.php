<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'artikel';

    /**
     * Mengindikasikan bahwa model harus memiliki timestamps (created_at dan updated_at).
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Atribut yang dapat diisi secara massal.
     *
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
    ];

    /**
     * Tipe data asli dari atribut model.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'diterbitkan_pada' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'riwayat_persetujuan' => 'json',
    ];

    //======================================================================
    // ACCESSORS
    //======================================================================

    /**
     * Accessor untuk mendapatkan URL lengkap gambar.
     * Membuat properti virtual 'gambar_url' pada model.
     *
     * @return string|null
     */
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return Storage::url($this->gambar);
        }
        return null;
    }

    /**
     * Accessor untuk mendapatkan nama penulis secara dinamis.
     *
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
     * Relasi one-to-many (inverse) ke model Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    /**
     * Relasi one-to-many (inverse) ke model Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Relasi one-to-many ke model KomentarArtikel.
     */
    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_artikel');
    }

    //======================================================================
    // SCOPES
    //======================================================================

    /**
     * Scope untuk pencarian berdasarkan judul atau isi.
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
     * Scope untuk menerapkan filter pada query.
     */
    public function scopeApplyFilter($query, $filter)
    {
        if (!$filter) {
            return $query;
        }

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