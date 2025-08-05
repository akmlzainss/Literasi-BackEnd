<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Siswa extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'siswa';
    protected $primaryKey = 'id';

    // Nonaktifkan timestamps (karena tabel tidak punya created_at & updated_at)
    public $timestamps = false;

    // Kolom-kolom yang boleh diisi massal
    protected $fillable = [
        'nis',
        'nama',
        'email',
        'kelas', // ✅ agar bisa tersimpan ke database
        'password',
        'status_aktif',
        'dibuat_pada'
    ];

    // Sembunyikan password saat model diubah ke array/JSON
    protected $hidden = ['password'];

    // Guard untuk autentikasi siswa
    protected $guard = 'siswa';

    public function getAuthPassword()
    {
        return $this->password;
    }

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
