<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'ecomTu', 'type' => 'string', 'group' => 'general', 'description' => 'Website name'],
            ['key' => 'site_description', 'value' => 'Your trusted online marketplace', 'type' => 'text', 'group' => 'general', 'description' => 'Website description'],
            ['key' => 'site_logo', 'value' => '', 'type' => 'string', 'group' => 'general', 'description' => 'Website logo URL'],
            ['key' => 'site_favicon', 'value' => '', 'type' => 'string', 'group' => 'general', 'description' => 'Website favicon URL'],
            ['key' => 'contact_email', 'value' => 'support@ecomtu.com', 'type' => 'string', 'group' => 'general', 'description' => 'Contact email address'],
            ['key' => 'contact_phone', 'value' => '+254 700 123 456', 'type' => 'string', 'group' => 'general', 'description' => 'Contact phone number'],
            ['key' => 'contact_address', 'value' => 'Nairobi, Kenya', 'type' => 'text', 'group' => 'general', 'description' => 'Contact address'],

            // Payment Settings
            ['key' => 'currency', 'value' => 'KES', 'type' => 'string', 'group' => 'payment', 'description' => 'Default currency'],
            ['key' => 'currency_symbol', 'value' => 'KSh', 'type' => 'string', 'group' => 'payment', 'description' => 'Currency symbol'],
            ['key' => 'commission_rate', 'value' => '15', 'type' => 'integer', 'group' => 'payment', 'description' => 'Platform commission rate (%)'],
            ['key' => 'transaction_fee', 'value' => '2', 'type' => 'integer', 'group' => 'payment', 'description' => 'Transaction fee (%)'],
            ['key' => 'minimum_payout', 'value' => '1000', 'type' => 'integer', 'group' => 'payment', 'description' => 'Minimum payout amount'],

            // Shipping Settings
            ['key' => 'default_shipping_cost', 'value' => '200', 'type' => 'integer', 'group' => 'shipping', 'description' => 'Default shipping cost'],
            ['key' => 'free_shipping_threshold', 'value' => '5000', 'type' => 'integer', 'group' => 'shipping', 'description' => 'Free shipping threshold'],
            ['key' => 'shipping_zones', 'value' => '[]', 'type' => 'json', 'group' => 'shipping', 'description' => 'Shipping zones configuration'],

            // Email Settings
            ['key' => 'mail_from_name', 'value' => 'Tununue-LTD', 'type' => 'string', 'group' => 'email', 'description' => 'Email sender name'],
            ['key' => 'mail_from_address', 'value' => 'noreply@tununue.com', 'type' => 'string', 'group' => 'email', 'description' => 'Email sender address'],
            ['key' => 'order_confirmation_email', 'value' => '1', 'type' => 'boolean', 'group' => 'email', 'description' => 'Send order confirmation emails'],
            ['key' => 'shipping_confirmation_email', 'value' => '1', 'type' => 'boolean', 'group' => 'email', 'description' => 'Send shipping confirmation emails'],

            // SEO Settings
            ['key' => 'meta_title', 'value' => 'ecomTu - Your Trusted Online Marketplace', 'type' => 'string', 'group' => 'seo', 'description' => 'Default meta title'],
            ['key' => 'meta_description', 'value' => 'Discover amazing products from trusted vendors on ecomTu', 'type' => 'text', 'group' => 'seo', 'description' => 'Default meta description'],
            ['key' => 'meta_keywords', 'value' => 'online marketplace, ecommerce, shopping, kenya', 'type' => 'string', 'group' => 'seo', 'description' => 'Default meta keywords'],

            // Social Media Settings
            ['key' => 'facebook_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Facebook page URL'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Twitter profile URL'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Instagram profile URL'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'LinkedIn profile URL'],

            // Security Settings
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'security', 'description' => 'Enable maintenance mode'],
            ['key' => 'maintenance_message', 'value' => 'We are currently performing maintenance. Please check back soon.', 'type' => 'text', 'group' => 'security', 'description' => 'Maintenance mode message'],
            ['key' => 'max_login_attempts', 'value' => '5', 'type' => 'integer', 'group' => 'security', 'description' => 'Maximum login attempts'],
            ['key' => 'lockout_duration', 'value' => '15', 'type' => 'integer', 'group' => 'security', 'description' => 'Account lockout duration (minutes)'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                    'description' => $setting['description'],
                    'is_public' => in_array($setting['group'], ['general', 'social']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
