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

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('deskripsi', 'like', "%{$search}%");
        }
        return $query;
    }

    // Scope untuk filter
    public function scopeApplyFilter($query, $filter)
    {
        if (!$filter) return $query;

        switch ($filter) {
            case 'with_articles':
                return $query->withCount('artikel')->having('artikel_count', '>', 0);
            case 'no_articles':
                return $query->withCount('artikel')->having('artikel_count', '=', 0);
            case 'az':
                return $query->orderBy('nama', 'asc');
            case 'za':
                return $query->orderBy('nama', 'desc');
            case 'newest':
                return $query->orderBy('dibuat_pada', 'desc');
            case 'oldest':
                return $query->orderBy('dibuat_pada', 'asc');
            default:
                return $query;
        }
    }
}