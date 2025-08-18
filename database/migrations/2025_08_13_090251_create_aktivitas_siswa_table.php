<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aktivitas_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama siswa (atau bisa diganti siswa_id jika pakai relasi)
            $table->string('aktivitas'); // Jenis aktivitas (Upload Artikel, Rating, Komentar, Login, Logout, dll)
            $table->string('artikel')->nullable(); // Judul artikel terkait (jika ada)

            // kalau mau lebih strict pakai enum
            $table->enum('status', ['draft', 'menunggu', 'disetujui', 'ditolak'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aktivitas_siswa');
    }
};
