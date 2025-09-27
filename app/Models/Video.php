<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'videos';

    protected $fillable = [
        'id_siswa',
        'id_kategori',
        'judul',
        'deskripsi',
        'video_path',
        'thumbnail_path',
        'status',
        'jumlah_dilihat',
        'jumlah_suka',
    ];
    
    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    
    // Catatan: Untuk komentar, suka, dan bookmark,
    // pendekatan terbaik adalah menggunakan Polymorphic Relationships.
    // Namun, untuk kesederhanaan, kita akan buat tabel interaksi baru
    // yang mirip dengan artikel untuk saat ini.

    public function getVideoUrlAttribute()
    {
        return $this->video_path ? Storage::url($this->video_path) : null;
    }
}
