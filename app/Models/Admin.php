<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    public $timestamps = false; // Tidak pakai timestamps

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'nama_pengguna',
        'email',
        'password',
        'status_aktif',
        'dibuat_pada',
        'last_login_at',
        'last_password_changed_at' // Tambahkan kolom foto profil
    ];

    protected $hidden = ['password'];

    protected $guard = 'admin'; // Guard kustom

    public function getAuthPassword()
    {
        return $this->password; // Override nama kolom password
    }

    // Relasi ke model lain
    public function usulanKategori()
    {
        return $this->hasMany(UsulanKategori::class, 'id_admin_persetujuan');
    }

    public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class, 'id_admin');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_admin');
    }

    public function logAdmin()
    {
        return $this->hasMany(LogAdmin::class, 'id_admin');
    }
}
