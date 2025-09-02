<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table = 'log_admin';
    public $timestamps = false;

    protected $fillable = [
        'id_admin',
        'jenis_aksi',
        'aksi',
        'referensi_tipe',
        'referensi_id',
        'detail',
        'dibuat_pada'
    ];

   protected $casts = [
    'dibuat_pada' => 'datetime',
];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}

