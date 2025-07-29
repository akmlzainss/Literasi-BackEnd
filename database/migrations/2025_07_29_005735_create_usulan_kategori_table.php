<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsulanKategoriTable extends Migration
{
    public function up()
    {
        Schema::create('usulan_kategori', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->unsignedBigInteger('id_admin_persetujuan')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->softDeletes();

            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_admin_persetujuan')->references('id')->on('admin')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usulan_kategori');
    }
};