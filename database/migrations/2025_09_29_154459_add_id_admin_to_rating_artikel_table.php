<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdAdminToRatingArtikelTable extends Migration
{
    public function up()
    {
        Schema::table('rating_artikel', function (Blueprint $table) {
            if (!Schema::hasColumn('rating_artikel', 'id_admin')) {
                $table->unsignedBigInteger('id_admin')->nullable()->after('id_siswa');
                $table->foreign('id_admin')->references('id')->on('admin')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('rating_artikel', function (Blueprint $table) {
            $table->dropForeign(['id_admin']);
            $table->dropColumn('id_admin');
        });
    }
}