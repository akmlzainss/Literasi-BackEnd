<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Siswa extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nis', 'nama', 'email', 'password', 'status_aktif', 'dibuat_pada'];
    protected $hidden = ['password'];

    protected $guard = 'siswa';

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_siswa');
    }

    public function usulanKategori()
    {
        return $this->hasMany(UsulanKategori::class, 'id_siswa');
    }

    public function nilaiArtikel()
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
};