<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePhotoPathToAdminTable extends Migration
{
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            if (!Schema::hasColumn('admin', 'profile_photo_path')) {
                $table->string('profile_photo_path')->nullable()->after('password');
            }
        });
    }

    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            if (Schema::hasColumn('admin', 'profile_photo_path')) {
                $table->dropColumn('profile_photo_path');
            }
        });
    }
}