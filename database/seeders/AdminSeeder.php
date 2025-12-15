<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash; // It's better practice to use Hash facade

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method uses firstOrCreate to prevent duplicate entry errors.
     * It checks for an existing user by email before attempting to create one.
     *
     * @return void
     */
    public function run()
    {
        // Admin 1: Checks for 'admin@example.com', creates if not found.
        Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nama_pengguna' => 'admin1',
                'password' => Hash::make('admin123'), // Use Hash::make for consistency
                'status_aktif' => true,
            ]
        );

        // Admin 2: Checks for 'admin2@example.com', creates if not found.
        Admin::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'nama_pengguna' => 'admin2',
                'password' => Hash::make('admin1234'),
                'status_aktif' => true,
            ]
        );

        Admin::firstOrCreate(
            ['email' => 'admin3@example.com'],
            [
                'nama_pengguna' => 'admin3',
                'password' => Hash::make('admin1234'),
                'status_aktif' => true,
            ]
        );
    }
}