<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('log_admin', function (Blueprint $table) {
            $table->string('referensi_tipe', 50)->nullable()->change();
            $table->unsignedBigInteger('referensi_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('log_admin', function (Blueprint $table) {
            $table->string('referensi_tipe', 50)->nullable(false)->change();
            $table->unsignedBigInteger('referensi_id')->nullable(false)->change();
        });
    }
};
