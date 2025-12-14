<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            // Tambah timestamps jika belum ada
            if (!Schema::hasColumn('notifikasi', 'created_at')) {
                $table->timestamps();
            }
        });

        // Update data lama: copy dibuat_pada ke created_at jika ada (setelah kolom dibuat)
        if (Schema::hasColumn('notifikasi', 'dibuat_pada') && Schema::hasColumn('notifikasi', 'created_at')) {
            DB::statement('UPDATE notifikasi SET created_at = dibuat_pada WHERE created_at IS NULL');
            DB::statement('UPDATE notifikasi SET updated_at = dibuat_pada WHERE updated_at IS NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
