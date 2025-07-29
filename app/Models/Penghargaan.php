<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    protected $table = 'penghargaan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_artikel', 'id_siswa', 'id_admin', 'jenis', 'bulan_tahun', 'deskripsi_penghargaan', 'dibuat_pada'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}