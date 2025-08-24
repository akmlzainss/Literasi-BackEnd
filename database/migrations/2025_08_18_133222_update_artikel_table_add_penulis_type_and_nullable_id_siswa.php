<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArtikelTableAddPenulisTypeAndNullableIdSiswa extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('penulis_type', ['admin', 'siswa'])->after('isi');
            $table->unsignedBigInteger('id_siswa')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('penulis_type');
            $table->unsignedBigInteger('id_siswa')->nullable(false)->change();
        });
    }
}