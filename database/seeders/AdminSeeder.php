<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama_pengguna' => 'admin1',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'status_aktif' => true,
            'created_at' => now(),
        ]);
    }
}