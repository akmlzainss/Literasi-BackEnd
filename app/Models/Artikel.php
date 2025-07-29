<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artikel extends Model
{
    use SoftDeletes;

    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id_siswa', 'id_kategori', 'judul', 'isi', 'jenis', 'status', 'alasan_penolakan', 'diterbitkan_pada', 'jumlah_dilihat', 'jumlah_suka', 'nilai_rata_rata', 'riwayat_persetujuan', 'usulan_kategori', 'dibuat_pada'];

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
}