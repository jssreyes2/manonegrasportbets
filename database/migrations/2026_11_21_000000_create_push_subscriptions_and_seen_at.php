<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('endpoint_hash', 64)->unique();
            $table->text('endpoint');
            $table->string('p256dh');
            $table->string('auth');
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::table('send_mail_picks', function (Blueprint $table) {
            // Para el contador de la campana: null = el cliente aún no lo ha visto
            $table->dateTime('seen_at')->nullable()->after('sent_at');
        });

        // Lo enviado antes de existir la campana se considera visto
        DB::table('send_mail_picks')->update(['seen_at' => DB::raw('COALESCE(sent_at, created_at)')]);
    }

    public function down(): void
    {
        Schema::table('send_mail_picks', fn(Blueprint $table) => $table->dropColumn('seen_at'));
        Schema::dropIfExists('push_subscriptions');
    }
};
