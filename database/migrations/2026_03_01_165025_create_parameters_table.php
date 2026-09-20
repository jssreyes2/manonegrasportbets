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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->decimal('dollar_rate', 10, 2)->default(0);
            $table->decimal('vat_value', 5, 2)->default(0);
            $table->string('invoice_number')->nullable();
            $table->decimal('igtf', 5, 2)->default(0);
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('identification')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('social_network_facebook')->nullable();
            $table->string('social_network_instagram')->nullable();
            $table->string('social_network_tiktok')->nullable();
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('set null');
            $table->string('identity_mobile_payment')->nullable();
            $table->string('phone_mobile_payment')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
