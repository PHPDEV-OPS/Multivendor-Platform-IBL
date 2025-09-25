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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // For guest users
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // For authenticated users
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Price at time of adding to cart
            $table->json('options')->nullable(); // For product variations, customizations
            $table->timestamps();
            
            // Ensure unique combination of session/user and product
            $table->unique(['session_id', 'product_id'], 'cart_session_product_unique');
            $table->unique(['user_id', 'product_id'], 'cart_user_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
