<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penghargaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_video')->nullable()->after('id_artikel');
            
            // Add foreign key constraint
            $table->foreign('id_video')
                  ->references('id')
                  ->on('videos')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('penghargaan', function (Blueprint $table) {
            $table->dropForeign(['id_video']);
            $table->dropColumn('id_video');
        });
    }
};