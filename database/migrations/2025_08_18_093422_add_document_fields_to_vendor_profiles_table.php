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
        Schema::table('vendor_profiles', function (Blueprint $table) {
            // Document uploads
            $table->string('kra_certificate')->nullable()->after('business_license');
            $table->string('certificate_of_registration')->nullable()->after('kra_certificate');
            $table->string('id_card_front')->nullable()->after('certificate_of_registration');
            $table->string('id_card_back')->nullable()->after('id_card_front');

            // Additional contact details
            $table->string('alternative_phone')->nullable()->after('contact_phone');
            $table->string('whatsapp_number')->nullable()->after('alternative_phone');
            $table->string('physical_address')->nullable()->after('business_address');
            $table->string('postal_address')->nullable()->after('physical_address');
            $table->string('city')->nullable()->after('postal_address');
            $table->string('county')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('county');

            // Business details
            $table->string('business_registration_number')->nullable()->after('tax_id');
            $table->string('kra_pin')->nullable()->after('business_registration_number');
            $table->date('business_start_date')->nullable()->after('kra_pin');
            $table->string('number_of_employees', 50)->nullable()->after('business_start_date');
            $table->text('business_description')->nullable()->after('number_of_employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'kra_certificate',
                'certificate_of_registration',
                'id_card_front',
                'id_card_back',
                'alternative_phone',
                'whatsapp_number',
                'physical_address',
                'postal_address',
                'city',
                'county',
                'postal_code',
                'business_registration_number',
                'kra_pin',
                'business_start_date',
                'number_of_employees',
                'business_description'
            ]);
        });
    }
};
