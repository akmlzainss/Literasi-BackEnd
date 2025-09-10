<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $timestamps = true; // Aktifkan timestamps

    protected $fillable = [
        'nama_pengguna',
        'email',
        'password',
        'status_aktif',
        'last_login_at',
        'last_password_changed_at',
        'remember_token',
    ];

    protected $hidden = ['password'];

    protected $guard = 'admin';

    public function getAuthPassword()
    {
        return $this->password;
    }

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