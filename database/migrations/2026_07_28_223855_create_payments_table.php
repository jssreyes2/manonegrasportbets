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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique(); // id del pago ('pay_Oe4sGZEKplPR5u')
            $table->string('status');               // open, paid, etc.
            $table->string('substatus')->nullable();// incomplete, etc.
            $table->decimal('total', 10, 2);        // 1.00
            $table->string('currency', 3);          // usd
            $table->timestamp('paid_at')->nullable();
            
            // Relaciones / Referencias externas
            $table->string('whop_user_id');         // user_qUqTLoNtKZoFa
            $table->string('username')->nullable(); // jesus1e
            $table->string('plan_id');              // plan_iSQCJG9nOe7PJ
            $table->string('company_id');           // biz_Hb8L0MElxsXfKv
            
            // Información de tarjeta
            $table->string('card_brand')->nullable(); // visa
            $table->string('card_last4', 4)->nullable(); // 4242
            
            // Metadatos de tu sistema (personalizados)
            $table->string('website_plan')->nullable();     // elite
            $table->unsignedBigInteger('website_user_id')->nullable(); // 9
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
