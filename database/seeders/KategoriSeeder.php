<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        Kategori::create(['nama' => 'Cerpen', 'deskripsi' => 'Cerita pendek', 'dibuat_pada' => now()]);
        Kategori::create(['nama' => 'Motivasi', 'deskripsi' => 'Tulisan motivasi', 'dibuat_pada' => now()]);
    }
}