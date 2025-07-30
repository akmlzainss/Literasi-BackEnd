<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengguna')->unique();
            $table->string('email')->unique();
            $table->string('password'); // Ganti 'kata_sandi' menjadi 'password'
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('created_at')->useCurrent(); // Ganti 'dibuat_pada' menjadi 'created_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
}