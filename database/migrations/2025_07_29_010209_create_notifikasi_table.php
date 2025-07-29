<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->string('judul');
            $table->text('pesan');
            $table->enum('jenis', ['komentar', 'like', 'rating', 'disetujui', 'ditolak', 'diberi_penghargaan']);
            $table->enum('referensi_tipe', ['artikel', 'komentar_artikel', 'penghargaan']);
            $table->unsignedBigInteger('referensi_id');
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
};
