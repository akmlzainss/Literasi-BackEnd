<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'siswa';
    public $timestamps = true;

    protected $fillable = [
        'nis',
        'nama',
        'email',
        'kelas',
        'foto_profil',
        'password',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'status_aktif' => 'boolean', // Optional tapi recommended
    ];

    /* =====================
     |   RELASI
     ===================== */
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_siswa');
    }

    public function video()
    {
        return $this->hasMany(Video::class, 'id_siswa');
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

    /* =====================
     |   HELPER TRASH/RESTORE
     ===================== */
    public static function getTrash()
    {
        return self::onlyTrashed()->get();
    }

    public static function restoreById($id)
    {
        $siswa = self::onlyTrashed()->findOrFail($id);
        return $siswa->restore();
    }

    public static function forceDeleteById($id)
    {
        $siswa = self::onlyTrashed()->findOrFail($id);
        return $siswa->forceDelete();
    }
}
