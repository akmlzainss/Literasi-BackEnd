<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraksiArtikel extends Model
{
    protected $table = 'interaksi_artikel';
    protected $primaryKey = 'id';

    /**
     * PERBAIKAN: Beri tahu Laravel untuk menggunakan 'dibuat_pada'
     * dan nonaktifkan 'updated_at'.
     */
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    // Pastikan timestamps tetap aktif (true adalah default)
    public $timestamps = true;

    // 'dibuat_pada' tidak perlu ada di fillable karena akan diisi otomatis oleh Laravel
    protected $fillable = ['id_artikel', 'id_siswa', 'jenis'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}