<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraksiVideo extends Model
{
    protected $table = 'interaksi_video';
    protected $primaryKey = 'id';
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;
    public $timestamps = true;

    protected $fillable = ['id_video', 'id_siswa', 'jenis'];

    public function video()
    {
        return $this->belongsTo(Video::class, 'id_video');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}