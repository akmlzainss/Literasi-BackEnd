<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarArtikel extends Model
{
    protected $table = 'komentar_artikel';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_artikel', 'id_siswa', 'id_komentar_parent', 'depth', 'komentar', 'dibuat_pada'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function parentKomentar()
    {
        return $this->belongsTo(KomentarArtikel::class, 'id_komentar_parent');
    }

    public function replies()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_komentar_parent');
    }
}