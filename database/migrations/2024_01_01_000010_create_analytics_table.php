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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_visitors')->default(0);
            $table->integer('unique_visitors')->default(0);
            $table->integer('page_views')->default(0);
            $table->integer('orders_count')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0.00);
            $table->decimal('average_order_value', 10, 2)->default(0.00);
            $table->integer('products_sold')->default(0);
            $table->integer('new_customers')->default(0);
            $table->integer('returning_customers')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0.00);
            $table->decimal('bounce_rate', 5, 2)->default(0.00);
            $table->integer('session_duration')->default(0); // in seconds
            $table->json('top_products')->nullable();
            $table->json('top_categories')->nullable();
            $table->json('traffic_sources')->nullable();
            $table->json('device_types')->nullable();
            $table->json('locations')->nullable();
            $table->timestamps();
            
            $table->unique(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
