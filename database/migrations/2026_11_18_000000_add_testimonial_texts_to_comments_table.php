<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'testimonial_es')) {
                $table->text('testimonial_es')->nullable()->after('is_testimonial')->comment('Testimonio publicado en español');
            }
            
            if (!Schema::hasColumn('comments', 'testimonial_en')) {
                $table->text('testimonial_en')->nullable()->after('testimonial_es')->comment('Testimonio publicado en inglés');
            }
        });
    }
    
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            foreach (['testimonial_es', 'testimonial_en'] as $column) {
                if (Schema::hasColumn('comments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
