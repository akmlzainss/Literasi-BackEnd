<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten');
            $table->string('gambar')->nullable();
            $table->enum('status', ['draft', 'review', 'published', 'rejected'])->default('draft');
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('set null');
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel');
    }
};
