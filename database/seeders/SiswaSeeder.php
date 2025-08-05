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
            'password' => bcrypt('password123'),
            'kelas' => 'XII RPL 2',
            'created_at' => now(),
        ]);
        // Tambah data lain kalau perlu
    }
}