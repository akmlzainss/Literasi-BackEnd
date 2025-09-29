<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table = 'log_admin';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_admin',
        'jenis_aksi',
        'aksi',
        'referensi_tipe',
        'referensi_id',
        'detail',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'detail' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id');
    }
}