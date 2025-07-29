<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaArtikelTable extends Migration
{
    public function up()
    {
        Schema::create('media_artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_artikel');
            $table->enum('jenis', ['image', 'video', 'link']);
            $table->string('url');
            $table->integer('urutan');
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_artikel')->references('id')->on('artikel')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_artikel');
    }
};
