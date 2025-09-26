<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_kategori')->nullable()->constrained('kategori')->onDelete('set null');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('video_path'); // Path ke file video
            $table->string('thumbnail_path')->nullable(); // Path ke thumbnail (opsional, bisa digenerate)
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->integer('jumlah_dilihat')->default(0);
            $table->integer('jumlah_suka')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};

