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
            $table->string('kata_sandi');
            $table->string('kelas'); // Kolom kelas ditambahkan
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswa');
    }
};
