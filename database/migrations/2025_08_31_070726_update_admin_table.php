<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            // Tambahkan kolom yang hilang dengan pengecekan
            if (!Schema::hasColumn('admin', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('status_aktif');
            }
            if (!Schema::hasColumn('admin', 'last_password_changed_at')) {
                $table->timestamp('last_password_changed_at')->nullable()->after('last_login_at');
            }

            // Ganti $table->timestamps(); dengan pengecekan individual (INI BAGIAN PENTING)
            if (!Schema::hasColumn('admin', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('admin', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }

            // Hapus kolom dibuat_pada jika ada
            if (Schema::hasColumn('admin', 'dibuat_pada')) {
                $table->dropColumn('dibuat_pada');
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
        Schema::table('admin', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan di 'up()' dengan aman
            $columnsToDrop = ['last_login_at', 'last_password_changed_at', 'created_at', 'updated_at'];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('admin', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Kembalikan kolom 'dibuat_pada' jika belum ada
            if (!Schema::hasColumn('admin', 'dibuat_pada')) {
                $table->timestamp('dibuat_pada')->useCurrent()->nullable()->after('status_aktif');
            }
        });
    }
}