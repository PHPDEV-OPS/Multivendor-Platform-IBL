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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['flat_rate', 'free', 'weight_based', 'price_based'])->default('flat_rate');
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->decimal('minimum_order_amount', 10, 2)->default(0.00);
            $table->decimal('maximum_order_amount', 10, 2)->nullable();
            $table->decimal('weight_from', 8, 2)->nullable();
            $table->decimal('weight_to', 8, 2)->nullable();
            $table->integer('delivery_days_min')->nullable();
            $table->integer('delivery_days_max')->nullable();
            $table->json('applicable_regions')->nullable(); // Country/State codes
            $table->json('excluded_regions')->nullable(); // Country/State codes
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
