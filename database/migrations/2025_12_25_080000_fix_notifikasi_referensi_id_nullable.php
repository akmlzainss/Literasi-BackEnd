<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix referensi_id constraint - make it truly nullable and remove any NOT NULL constraint
     */
    public function up(): void
    {
        // Drop foreign key if exists, then modify column
        Schema::table('notifikasi', function (Blueprint $table) {
            // Make referensi_id truly nullable with default null
            $table->unsignedBigInteger('referensi_id')->nullable()->default(null)->change();
        });
        
        // Also ensure referensi_tipe can be null
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN referensi_tipe VARCHAR(50) NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed for rollback
    }
};
