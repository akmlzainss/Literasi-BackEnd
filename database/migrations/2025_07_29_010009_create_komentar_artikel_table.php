<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarArtikelTable extends Migration
{
    public function up()
    {
        Schema::create('komentar_artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_komentar_parent')->nullable();
            $table->integer('depth')->default(0);
            $table->text('komentar');
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_artikel')->references('id')->on('artikel')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_komentar_parent')->references('id')->on('komentar_artikel')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentar_artikel');
    }
};
