<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyIdSiswaToNullableInKomentarArtikelTable extends Migration
{
    public function up()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_siswa')->nullable()->change();
            $table->unsignedBigInteger('id_admin')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_siswa')->nullable(false)->change();
            $table->unsignedBigInteger('id_admin')->nullable(false)->change();
        });
    }
}