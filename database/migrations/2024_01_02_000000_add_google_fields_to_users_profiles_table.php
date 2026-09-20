<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('users_profiles', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('users_profiles', 'avatar')) {
                $table->string('avatar')->nullable()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn(['name', 'avatar']);
        });
    }
};
