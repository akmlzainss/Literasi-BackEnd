<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIdSiswaNullableInRatingArtikelTable extends Migration
{
    public function up()
    {
        Schema::table('rating_artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_siswa')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('rating_artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_siswa')->nullable(false)->change();
        });
    }
}