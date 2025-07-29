<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama_pengguna', 'email', 'kata_sandi', 'status_aktif', 'dibuat_pada'];

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