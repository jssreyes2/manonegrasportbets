<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('web_suscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('web_suscriptions', 'language')) {
                $table->string('language', 2)->nullable()->comment('Idioma de la web al suscribirse');
            }
            
            if (!Schema::hasColumn('web_suscriptions', 'invitations_sent')) {
                $table->unsignedTinyInteger('invitations_sent')->default(0)->comment('Invitaciones a un plan de pago enviadas');
            }
            
            if (!Schema::hasColumn('web_suscriptions', 'last_invitation_at')) {
                $table->dateTime('last_invitation_at')->nullable();
            }
            
            if (!Schema::hasColumn('web_suscriptions', 'unsubscribed_at')) {
                $table->dateTime('unsubscribed_at')->nullable()->comment('Se dio de baja de las promociones');
            }
        });
    }
    
    public function down(): void
    {
        Schema::table('web_suscriptions', function (Blueprint $table) {
            foreach (['language', 'invitations_sent', 'last_invitation_at', 'unsubscribed_at'] as $column) {
                if (Schema::hasColumn('web_suscriptions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
