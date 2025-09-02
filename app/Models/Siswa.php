<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'siswa';
    public $timestamps = true;

    /**
     * Kolom created_at dan updated_at tidak perlu ada di fillable.
     * Laravel mengisinya secara otomatis.
     */
    protected $fillable = [
        'nis',
        'nama',
        'email',
        'kelas',
        'password',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
    ];

    //protected $guard = 'siswa';

    //public function getAuthPassword()
    //{
      //  return $this->password;
    //}

    // Relasi-relasi (sesuaikan jika kamu tidak pakai fitur ini)
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
}
