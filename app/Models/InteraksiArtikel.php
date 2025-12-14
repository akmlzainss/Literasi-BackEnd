<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraksiArtikel extends Model
{
    protected $table = 'interaksi_artikel';
    protected $primaryKey = 'id';

    /**
     * PERBAIKAN: Table tidak memiliki timestamps
     */
    public $timestamps = false;

    protected $fillable = ['id_artikel', 'id_siswa', 'jenis'];

    protected $casts = [];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
