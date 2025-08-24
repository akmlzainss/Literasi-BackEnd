<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelTable extends Migration
{
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa')->nullable(); // Make nullable
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->string('judul');
            $table->text('isi');

            $table->enum('jenis', ['bebas', 'resensi_buku', 'resensi_film', 'video']);
            $table->enum('status', ['draf', 'menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('diterbitkan_pada')->nullable();
            $table->integer('jumlah_dilihat')->default(0);
            $table->integer('jumlah_suka')->default(0);
            $table->decimal('nilai_rata_rata', 5, 2)->nullable();
            $table->json('riwayat_persetujuan')->nullable();
            $table->string('usulan_kategori')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->softDeletes();

            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('set null');
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel');
    }
}