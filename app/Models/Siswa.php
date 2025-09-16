<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable; // penting biar bisa pakai fitur auth bawaan

class Siswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'siswa'; // atau 'siswas' kalau migration kamu pakai plural
    public $timestamps = true;

    protected $fillable = [
        'nis',
        'nama_pengguna',
        'email',
        'kelas',
        'password',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token', // sebaiknya tambahkan ini
    ];

    /**
     * Relasi-relasi siswa
     */
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
