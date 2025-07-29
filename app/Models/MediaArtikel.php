<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaArtikel extends Model
{
    protected $table = 'media_artikel';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_artikel', 'jenis', 'url', 'urutan', 'dibuat_pada'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }
}