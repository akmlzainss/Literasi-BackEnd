<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penghargaan', function (Blueprint $table) {
            $table->boolean('arsip')->default(false)->after('dibuat_pada');
        });
    }

    public function down()
    {
        Schema::table('penghargaan', function (Blueprint $table) {
            $table->dropColumn('arsip');
        });
    }
};