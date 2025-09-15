<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            // Mengubah nama kolom dari 'id_artikel' menjadi 'artikel_id'
            $table->renameColumn('id_artikel', 'artikel_id');
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