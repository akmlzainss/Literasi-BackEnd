<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsulanKategori extends Model
{
    use SoftDeletes;

    protected $table = 'usulan_kategori';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id_siswa', 'nama', 'deskripsi', 'status', 'alasan_penolakan', 'id_admin_persetujuan', 'dibuat_pada'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin_persetujuan');
    }
}