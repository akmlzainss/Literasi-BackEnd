<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarVideoTable extends Migration
{
    public function up()
    {
        Schema::create('komentar_video', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_video');
            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->text('komentar');
            $table->unsignedBigInteger('id_komentar_parent')->nullable();
            $table->integer('depth')->default(0);
            $table->timestamps();

            $table->foreign('id_video')->references('id')->on('videos')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('cascade');
            $table->foreign('id_komentar_parent')->references('id')->on('komentar_video')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentar_video');
    }
}