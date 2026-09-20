<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('send_mail_picks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pick_id')->constrained('picks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('send_date');
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('send_date');
            $table->index('sent_at');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_picks');
    }
};
