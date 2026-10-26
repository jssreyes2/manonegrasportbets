<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'subject')) {
                $table->string('subject', 30)->nullable()->after('email')->comment('Asunto del comentario');
            }

            // Solo los comentarios marcados por el admin se publican como testimonio en la web
            if (!Schema::hasColumn('comments', 'is_testimonial')) {
                $table->boolean('is_testimonial')->default(false)->after('answered')->comment('Publicado como testimonio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            foreach (['subject', 'is_testimonial'] as $column) {
                if (Schema::hasColumn('comments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
