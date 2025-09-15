<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingArtikelTable extends Migration
{
    public function up()
    {
        Schema::create('rating_artikel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_artikel')
                  ->constrained('artikel')
                  ->cascadeOnDelete();

            $table->foreignId('id_siswa')
                  ->constrained('siswa')
                  ->cascadeOnDelete();

            $table->tinyInteger('rating'); // nilai rating 1–5
            $table->json('riwayat_rating')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_artikel');
    }
}
