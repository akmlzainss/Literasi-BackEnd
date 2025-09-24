<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penghargaan extends Model
{
    use SoftDeletes;

    protected $table = 'penghargaan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_artikel',
        'id_siswa',
        'id_admin',
        'jenis',
        'bulan_tahun',
        'deskripsi_penghargaan',
        'dibuat_pada'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /* =====================
     |   RELASI
     ===================== */
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

    /* =====================
     |   HELPER TRASH/RESTORE
     ===================== */
    public static function getTrash()
    {
        return self::onlyTrashed()->get();
    }

    public static function restoreById($id)
    {
        $penghargaan = self::onlyTrashed()->findOrFail($id);
        return $penghargaan->restore();
    }

    public static function forceDeleteById($id)
    {
        $penghargaan = self::onlyTrashed()->findOrFail($id);
        return $penghargaan->forceDelete();
    }
}
