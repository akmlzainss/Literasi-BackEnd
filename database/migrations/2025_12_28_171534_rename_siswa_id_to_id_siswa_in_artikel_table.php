<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            // First, drop the foreign key constraint if it exists
            if (Schema::hasColumn('artikel', 'siswa_id')) {
                // Use raw SQL for MySQL to rename the column
                $table->renameColumn('siswa_id', 'id_siswa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            if (Schema::hasColumn('artikel', 'id_siswa')) {
                $table->renameColumn('id_siswa', 'siswa_id');
            }
        });
    }
};
