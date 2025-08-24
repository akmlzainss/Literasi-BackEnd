<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAdminTable extends Migration
{
    public function up()
    {
        Schema::create('log_admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_admin');
            $table->enum('jenis_aksi', [
                'setujui_artikel',
                'tolak_artikel',
                'setujui_kategori',
                'tolak_kategori',
                'berikan_penghargaan',
                'login',
                'logout'
            ]);
            $table->string('aksi');
            $table->enum('referensi_tipe', [
                'artikel',
                'kategori',
                'siswa',
                'penghargaan',
                'admin'
            ]);
            $table->unsignedBigInteger('referensi_id');
            $table->text('detail')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_admin');
    }
};
