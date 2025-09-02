<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table = 'log_admin';
    public $timestamps = true; // Aktifkan timestamps

    protected $fillable = [
        'id_admin',
        'jenis_aksi',
        'aksi',
        'referensi_tipe',
        'referensi_id',
        'detail',
    ];

   protected $casts = [
    'dibuat_pada' => 'datetime',
];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}

