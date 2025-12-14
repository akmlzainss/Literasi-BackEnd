<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArtikelTableAddPenulisTypeAndNullableIdSiswa extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('penulis_type', ['admin', 'siswa'])->after('konten');
            $table->unsignedBigInteger('siswa_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('penulis_type');
            $table->unsignedBigInteger('siswa_id')->nullable(false)->change();
        });
    }
}
