<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Puede que la columna ya se haya creado manualmente en algún entorno
        if (Schema::hasColumn('subscriptions', 'sure_bettor_day')) {
            return;
        }

        // Día Elite cuyos picks perdidos activaron el seguro del apostador
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->date('sure_bettor_day')->nullable()->after('sure_bettor')->comment('Dia que activo el seguro');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('subscriptions', 'sure_bettor_day')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('sure_bettor_day');
        });
    }
};
