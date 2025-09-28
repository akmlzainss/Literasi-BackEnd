<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarVideo extends Model
{
    protected $table = 'komentar_video';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_video',
        'id_siswa',
        'id_admin',
        'komentar',
        'id_komentar_parent',
        'depth',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class, 'id_video');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function parent()
    {
        return $this->belongsTo(KomentarVideo::class, 'id_komentar_parent');
    }

    public function replies()
    {
        return $this->hasMany(KomentarVideo::class, 'id_komentar_parent');
    }
}