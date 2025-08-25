<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash; // Import the Hash facade

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This uses firstOrCreate to prevent duplicate entries based on the 'nis' column.
     *
     * @return void
     */
    public function run()
    {
        Siswa::firstOrCreate(
            ['nis' => 'S001'], // The unique attribute to check against
            [
                'nama' => 'Andi',
                'email' => 'andi@example.com',
                'password' => Hash::make('password123'), // Use Hash::make()
                'kelas' => 'XII RPL 2',
            ]
        );
    }
}
