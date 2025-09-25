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
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('vendor_code')->unique();
            $table->string('company_name');
            $table->string('business_type')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('business_license')->nullable();
            $table->text('business_address');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->decimal('commission_rate', 5, 2)->default(0.00);
            $table->enum('status', ['pending', 'approved', 'suspended', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->json('bank_details')->nullable();
            $table->string('store_logo')->nullable();
            $table->string('store_banner')->nullable();
            $table->json('store_settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_profiles');
    }
};
