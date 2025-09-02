<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeReferensiTipeToStringInLogAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_admin', function (Blueprint $table) {
            // Mengubah kolom referensi_tipe menjadi string (VARCHAR) dengan panjang 50 karakter
            $table->string('referensi_tipe', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_admin', function (Blueprint $table) {
            // Baris ini hanya untuk rollback, mungkin perlu disesuaikan
            // jika Anda tahu nilai ENUM aslinya.
            // Untuk sekarang, fokus pada fungsi up().
        });
    }
}