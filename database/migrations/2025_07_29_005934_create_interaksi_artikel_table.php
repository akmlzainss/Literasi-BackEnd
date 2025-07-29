<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteraksiArtikelTable extends Migration
{
    public function up()
    {
        Schema::create('interaksi_artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_siswa');
            $table->enum('jenis', ['suka', 'bookmark']);
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_artikel')->references('id')->on('artikel')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interaksi_artikel');
    }
};