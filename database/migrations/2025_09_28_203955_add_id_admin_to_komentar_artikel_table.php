<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdAdminToKomentarArtikelTable extends Migration
{
    public function up()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_admin')->nullable()->after('id_siswa');
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('komentar_artikel', function (Blueprint $table) {
            $table->dropForeign(['id_admin']);
            $table->dropColumn('id_admin');
        });
    }
}