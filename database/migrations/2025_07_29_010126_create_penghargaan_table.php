<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenghargaanTable extends Migration
{
    public function up()
    {
        Schema::create('penghargaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_artikel')->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_admin');
            $table->enum('jenis', ['bulanan', 'spesial']);
            $table->date('bulan_tahun');
            $table->text('deskripsi_penghargaan');
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_artikel')->references('id')->on('artikel')->onDelete('set null');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penghargaan');
    }
};