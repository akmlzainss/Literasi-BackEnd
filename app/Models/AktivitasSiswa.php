<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasSiswa extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_siswa'; // Nama tabel

    protected $fillable = [
        'nama',
        'aktivitas',
        'artikel',
        'status',
    ];
}
