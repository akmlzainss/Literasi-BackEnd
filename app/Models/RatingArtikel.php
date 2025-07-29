<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingArtikel extends Model
{
    protected $table = 'rating_artikel';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_artikel',
        'id_siswa',
        'rating',
        'riwayat_rating',
        'dibuat_pada',
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
