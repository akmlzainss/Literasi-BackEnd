<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nis', 'nama', 'email', 'kata_sandi', 'status_aktif', 'dibuat_pada'];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_siswa');
    }

    public function usulanKategori()
    {
        return $this->hasMany(UsulanKategori::class, 'id_siswa');
    }

    public function RatingArtikel()
    {
        return $this->hasMany(RatingArtikel::class, 'id_siswa');
    }

    public function interaksiArtikel()
    {
        return $this->hasMany(InteraksiArtikel::class, 'id_siswa');
    }

    public function komentarArtikel()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_siswa');
    }

    public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class, 'id_siswa');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_siswa');
    }
}