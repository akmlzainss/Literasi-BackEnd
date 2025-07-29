<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_siswa', 'id_admin', 'judul', 'pesan', 'jenis', 'referensi_tipe', 'referensi_id', 'sudah_dibaca', 'dibuat_pada'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}