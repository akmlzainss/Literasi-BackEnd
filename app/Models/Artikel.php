<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Artikel extends Model
{
    use SoftDeletes;

    protected $table = 'artikel';
    protected $primaryKey = 'id';
    public $timestamps = false; // Nonaktifkan timestamps default
    protected $dates = ['deleted_at', 'dibuat_pada', 'diterbitkan_pada']; // Daftarkan kolom tanggal
    protected $fillable = [
        'id_siswa', 'id_kategori', 'judul', 'isi', 'gambar', 'jenis', 'status', 
        'alasan_penolakan', 'diterbitkan_pada', 'jumlah_dilihat', 'jumlah_suka', 
        'nilai_rata_rata', 'riwayat_persetujuan', 'usulan_kategori', 'dibuat_pada'
    ];

    // Mutator untuk memastikan konversi ke Carbon
    public function setDibuatPadaAttribute($value)
    {
        $this->attributes['dibuat_pada'] = $value ? Carbon::parse($value) : now();
    }

    public function setDiterbitkanPadaAttribute($value)
    {
        $this->attributes['diterbitkan_pada'] = $value ? Carbon::parse($value) : null;
    }

    // Relasi dan scope tetap sama
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function RatingArtikel()
    {
        return $this->hasMany(RatingArtikel::class, 'id_artikel');
    }

    public function interaksiArtikel()
    {
        return $this->hasMany(InteraksiArtikel::class, 'id_artikel');
    }

    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_artikel');
    }

    public function mediaArtikel()
    {
        return $this->hasMany(MediaArtikel::class, 'id_artikel');
    }

    public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class, 'id_artikel');
    }

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