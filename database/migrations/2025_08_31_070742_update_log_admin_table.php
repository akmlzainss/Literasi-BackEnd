<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLogAdminTable extends Migration
{
    public function up()
    {
        Schema::table('log_admin', function (Blueprint $table) {
            // Ubah kolom jenis_aksi dari ENUM ke string
            $table->string('jenis_aksi', 50)->change();
            // Tambahkan timestamps (created_at, updated_at)
            $table->timestamps();
            // Hapus kolom dibuat_pada jika ada
            if (Schema::hasColumn('log_admin', 'dibuat_pada')) {
                $table->dropColumn('dibuat_pada');
            }
        });
    }

    public function down()
    {
        Schema::table('log_admin', function (Blueprint $table) {
            // Kembalikan ke ENUM jika rollback
            $table->enum('jenis_aksi', [
                'setujui_artikel',
                'tolak_artikel',
                'setujui_kategori',
                'tolak_kategori',
                'berikan_penghargaan',
                'login',
                'logout',
            ])->change();
            // Kembalikan kolom dibuat_pada dan hapus timestamps
            $table->timestamp('dibuat_pada')->useCurrent()->nullable()->after('detail');
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}