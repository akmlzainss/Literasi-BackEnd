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
            // Check if columns exist before modifying
            if (!Schema::hasColumn('artikel', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }

            if (Schema::hasColumn('artikel', 'dibuat_pada') && !Schema::hasColumn('artikel', 'created_at')) {
                $table->renameColumn('dibuat_pada', 'created_at');
            }
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
