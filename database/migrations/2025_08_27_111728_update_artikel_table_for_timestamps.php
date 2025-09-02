<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            // 1. Tambahkan kolom updated_at terlebih dahulu.
            //    Kita letakkan setelah 'diterbitkan_pada' agar posisinya rapi.
            $table->timestamp('updated_at')->nullable()->after('diterbitkan_pada');

            // 2. Baru ganti nama kolom 'dibuat_pada' menjadi 'created_at'.
            $table->renameColumn('dibuat_pada', 'created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            // Urutan dibalik untuk rollback
            $table->renameColumn('created_at', 'dibuat_pada');
            $table->dropColumn('updated_at');
        });
    }
};