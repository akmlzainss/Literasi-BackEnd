<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        Siswa::create([
            'nis' => 'S001',
            'nama' => 'Andi',
            'email' => 'andi@example.com',
            'kata_sandi' => bcrypt('password123'),
            'status_aktif' => true,
            'dibuat_pada' => now(),
        ]);
        // Tambah data lain kalau perlu
    }
}