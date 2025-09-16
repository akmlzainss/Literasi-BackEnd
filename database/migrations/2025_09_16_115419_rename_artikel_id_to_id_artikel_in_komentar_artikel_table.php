<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            $table->renameColumn('artikel_id', 'id_artikel');
        });
    }

    public function down(): void
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            $table->renameColumn('id_artikel', 'artikel_id');
        });
    }
};
