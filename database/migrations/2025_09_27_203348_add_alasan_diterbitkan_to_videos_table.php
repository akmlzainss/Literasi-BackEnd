<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlasanDiterbitkanToVideosTable extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->text('alasan_penolakan')->nullable()->after('status');
            $table->timestamp('diterbitkan_pada')->nullable()->after('alasan_penolakan');
        });
    }

    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['alasan_penolakan', 'diterbitkan_pada']);
        });
    }
}