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
        Schema::table('users', function (Blueprint $table) {
            // Personal Information (skip phone as it already exists)
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other', 'prefer-not'])->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('gender');

            // Business Information
            $table->string('business_name')->nullable()->after('profile_image');
            $table->enum('business_type', ['individual', 'partnership', 'corporation', 'llc'])->nullable()->after('business_name');
            $table->string('tax_id')->nullable()->after('business_type');
            $table->string('business_website')->nullable()->after('tax_id');
            $table->text('business_description')->nullable()->after('business_website');
            $table->integer('years_in_business')->nullable()->after('business_description');
            $table->integer('number_of_employees')->nullable()->after('years_in_business');

            // Address Information (stored as JSON) - replace existing address field
            $table->json('primary_address')->nullable()->after('number_of_employees');
            $table->json('shipping_address')->nullable()->after('primary_address');

            // Social Media Links
            $table->string('facebook_url')->nullable()->after('shipping_address');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('instagram_url')->nullable()->after('twitter_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('youtube_url')->nullable()->after('linkedin_url');
            $table->string('tiktok_url')->nullable()->after('youtube_url');

            // Notification Settings
            $table->boolean('email_notifications')->default(true)->after('tiktok_url');
            $table->boolean('sms_notifications')->default(false)->after('email_notifications');
            $table->boolean('push_notifications')->default(true)->after('sms_notifications');
            $table->boolean('marketing_emails')->default(false)->after('push_notifications');

            // Account Tracking
            $table->timestamp('last_login_at')->nullable()->after('marketing_emails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'gender',
                'bio',
                'business_name',
                'business_type',
                'tax_id',
                'business_website',
                'business_description',
                'years_in_business',
                'number_of_employees',
                'primary_address',
                'shipping_address',
                'facebook_url',
                'twitter_url',
                'instagram_url',
                'linkedin_url',
                'youtube_url',
                'tiktok_url',
                'email_notifications',
                'sms_notifications',
                'push_notifications',
                'marketing_emails',
                'last_login_at'
            ]);
        });
    }
};
