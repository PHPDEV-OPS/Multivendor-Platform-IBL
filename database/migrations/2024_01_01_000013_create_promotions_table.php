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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping', 'buy_one_get_one', 'flash_sale'])->default('percentage');
            $table->decimal('discount_value', 10, 2);
            $table->decimal('minimum_order_amount', 10, 2)->default(0.00);
            $table->decimal('maximum_discount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->integer('per_user_limit')->default(1);
            $table->json('applicable_products')->nullable(); // Product IDs
            $table->json('applicable_categories')->nullable(); // Category IDs
            $table->json('excluded_products')->nullable(); // Product IDs
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_first_time_only')->default(false);
            $table->boolean('is_new_customer_only')->default(false);
            
            // Banner Management Fields
            $table->string('banner_image')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_subtitle')->nullable();
            $table->string('banner_link')->nullable();
            $table->enum('banner_position', ['top', 'sidebar', 'footer', 'home_banner', 'category_banner'])->nullable();
            $table->boolean('banner_is_active')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
