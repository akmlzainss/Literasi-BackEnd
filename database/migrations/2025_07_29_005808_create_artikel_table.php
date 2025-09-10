<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['id_siswa']);
            $table->dropForeign(['id_kategori']);
        });

        Schema::table('artikel', function (Blueprint $table) {
            // Rename kolom
            $table->renameColumn('id_siswa', 'siswa_id');
            $table->renameColumn('id_kategori', 'kategori_id');
        });

        Schema::table('artikel', function (Blueprint $table) {
            // Pastikan kolom nullable untuk set null
            $table->unsignedBigInteger('siswa_id')->nullable()->change();
            $table->unsignedBigInteger('kategori_id')->nullable()->change();

            // Tambahkan foreign key baru
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('set null');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropForeign(['kategori_id']);
        });

        Schema::table('artikel', function (Blueprint $table) {
            $table->renameColumn('siswa_id', 'id_siswa');
            $table->renameColumn('kategori_id', 'id_kategori');
        });

        Schema::table('artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_siswa')->nullable()->change();
            $table->unsignedBigInteger('id_kategori')->nullable()->change();

            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('set null');
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('set null');
        });
    }
};
