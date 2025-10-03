<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_siswa',
        'id_kategori',
        'judul',
        'deskripsi',
        'video_path',
        'thumbnail_path',
        'status',
        'alasan_penolakan',
        'jumlah_dilihat',
        'diterbitkan_pada',
        'jumlah_suka'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function interaksi()
    {
        return $this->hasMany(InteraksiVideo::class, 'id_video');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarVideo::class, 'id_video');
    }


    public function getLikeCountAttribute() // Accessor untuk sum like jika belum auto-update
    {
        return $this->interaksi()->where('tipe', 'like')->count();
    }
}