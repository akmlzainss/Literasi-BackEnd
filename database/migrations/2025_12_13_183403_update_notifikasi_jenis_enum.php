<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update the enum to include 'sistem' and other missing values
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN jenis ENUM('komentar', 'like', 'rating', 'disetujui', 'ditolak', 'diberi_penghargaan', 'sistem', 'artikel_disetujui', 'artikel_ditolak', 'komentar_baru', 'penghargaan', 'video_disetujui', 'video_ditolak') NOT NULL");

        // Also update referensi_tipe to include null and video
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN referensi_tipe ENUM('artikel', 'komentar_artikel', 'penghargaan', 'video') NULL");

        // Make referensi_id nullable for system notifications
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('referensi_id')->nullable()->change();
        });
    }

    public function down()
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN jenis ENUM('komentar', 'like', 'rating', 'disetujui', 'ditolak', 'diberi_penghargaan') NOT NULL");
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN referensi_tipe ENUM('artikel', 'komentar_artikel', 'penghargaan') NOT NULL");

        Schema::table('notifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('referensi_id')->nullable(false)->change();
        });
    }
};
