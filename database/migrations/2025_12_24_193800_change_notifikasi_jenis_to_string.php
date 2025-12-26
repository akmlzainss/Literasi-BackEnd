<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ubah kolom jenis dari ENUM ke VARCHAR agar lebih fleksibel
     */
    public function up(): void
    {
        // Ubah jenis dari ENUM ke VARCHAR(50)
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN jenis VARCHAR(50) NOT NULL");
        
        // Ubah referensi_tipe juga dari ENUM ke VARCHAR
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN referensi_tipe VARCHAR(50) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke ENUM jika perlu rollback
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN jenis ENUM('komentar', 'like', 'rating', 'disetujui', 'ditolak', 'diberi_penghargaan', 'sistem', 'artikel_disetujui', 'artikel_ditolak', 'komentar_baru', 'penghargaan', 'video_disetujui', 'video_ditolak') NOT NULL");
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN referensi_tipe ENUM('artikel', 'komentar_artikel', 'penghargaan', 'video') NULL");
    }
};
