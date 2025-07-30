<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password'); // Ganti 'kata_sandi' menjadi 'password'
            $table->string('kelas', 50); // Tambah panjang maksimum
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('created_at')->useCurrent(); // Ganti 'dibuat_pada' menjadi 'created_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}