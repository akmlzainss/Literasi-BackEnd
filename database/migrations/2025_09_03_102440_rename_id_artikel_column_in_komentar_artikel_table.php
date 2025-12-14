<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            // Check if columns exist before renaming
            if (Schema::hasColumn('komentar_artikel', 'id_artikel') && !Schema::hasColumn('komentar_artikel', 'artikel_id')) {
                $table->renameColumn('id_artikel', 'artikel_id');
            }
        });
    }

    public function down()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            // Fungsi untuk rollback jika diperlukan
            $table->renameColumn('artikel_id', 'id_artikel');
        });
    }
};
