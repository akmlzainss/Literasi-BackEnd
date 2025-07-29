<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama', 'deskripsi', 'dibuat_pada'];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_kategori');
    }
}