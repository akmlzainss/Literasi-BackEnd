<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarArtikel extends Model
{
    protected $table = 'komentar_artikel';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_artikel',
        'id_siswa',
        'id_admin',
        'id_komentar_parent',
        'depth',
        'komentar',
        'dibuat_pada',
    ];

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id');
    }

    public function parentKomentar()
    {
        return $this->belongsTo(KomentarArtikel::class, 'id_komentar_parent', 'id');
    }

    public function replies()
    {
        return $this->hasMany(KomentarArtikel::class, 'id_komentar_parent', 'id');
    }
}