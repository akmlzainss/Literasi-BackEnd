<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingArtikel extends Model
{
    use HasFactory;

    protected $table = 'rating_artikel';

    protected $fillable = [
        'id_artikel',
        'id_siswa',
        'rating',
        'riwayat_rating',
        'dibuat_pada',
    ];

    protected $casts = [
        'riwayat_rating' => 'array',  // otomatis JSON ↔ array
        'dibuat_pada'    => 'datetime',
    ];

    // Nonaktifkan timestamps default Laravel
    public $timestamps = false;
}
