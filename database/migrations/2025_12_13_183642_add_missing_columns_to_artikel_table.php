<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            // Add missing columns for dashboard statistics
            if (!Schema::hasColumn('artikel', 'jumlah_dilihat')) {
                $table->integer('jumlah_dilihat')->default(0)->after('views');
            }
            if (!Schema::hasColumn('artikel', 'jumlah_suka')) {
                $table->integer('jumlah_suka')->default(0)->after('jumlah_dilihat');
            }
            if (!Schema::hasColumn('artikel', 'nilai_rata_rata')) {
                $table->decimal('nilai_rata_rata', 3, 2)->default(0)->after('jumlah_suka');
            }
        });

        // Copy views data to jumlah_dilihat if views column exists
        if (Schema::hasColumn('artikel', 'views')) {
            DB::statement('UPDATE artikel SET jumlah_dilihat = views WHERE jumlah_dilihat = 0');
        }
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn(['jumlah_dilihat', 'jumlah_suka', 'nilai_rata_rata']);
        });
    }
};
