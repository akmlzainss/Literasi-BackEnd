<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('komentar_artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->text('komentar');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id_artikel')->references('id')->on('artikel')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('set null');
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('komentar_artikel')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentar_artikel');
    }
};
