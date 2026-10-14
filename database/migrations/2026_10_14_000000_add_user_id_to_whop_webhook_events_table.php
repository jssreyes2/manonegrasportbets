<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Puede que la columna ya se haya creado manualmente en algún entorno
        if (Schema::hasColumn('whop_webhook_events', 'user_id')) {
            return;
        }

        Schema::table('whop_webhook_events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('event_type')->index();
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('whop_webhook_events', 'user_id')) {
            return;
        }

        Schema::table('whop_webhook_events', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
