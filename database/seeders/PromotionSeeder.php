<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            [
                'name' => 'Summer Sale 2024',
                'code' => 'SUMMER20',
                'description' => 'Get 20% off on all summer collection items. Limited time offer!',
                'type' => 'percentage',
                'discount_value' => 20.00,
                'minimum_order_amount' => 50.00,
                'maximum_discount' => 100.00,
                'usage_limit' => 100,
                'used_count' => 45,
                'per_user_limit' => 1,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'is_active' => true,
                'is_first_time_only' => false,
                'is_new_customer_only' => false,
                'banner_image' => 'promotions/banners/summer_sale_banner.jpg',
                'banner_title' => 'Summer Sale 2024',
                'banner_subtitle' => 'Up to 20% OFF',
                'banner_link' => '/categories',
                'banner_position' => 'top',
                'banner_is_active' => true,
            ],
            [
                'name' => 'Free Shipping Weekend',
                'code' => 'FREESHIP',
                'description' => 'Free shipping on all orders this weekend. No minimum purchase required.',
                'type' => 'free_shipping',
                'discount_value' => 0.00,
                'minimum_order_amount' => 0.00,
                'maximum_discount' => null,
                'usage_limit' => 50,
                'used_count' => 23,
                'per_user_limit' => 1,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(2),
                'is_active' => true,
                'is_first_time_only' => false,
                'is_new_customer_only' => false,
                'banner_image' => 'promotions/banners/free_shipping_banner.jpg',
                'banner_title' => 'Free Shipping Weekend',
                'banner_subtitle' => 'No Minimum Purchase',
                'banner_link' => '/products',
                'banner_position' => 'home_banner',
                'banner_is_active' => true,
            ],
            [
                'name' => 'New Customer Discount',
                'code' => 'NEWCUST10',
                'description' => 'Welcome discount for new customers. Get $10 off your first order.',
                'type' => 'fixed_amount',
                'discount_value' => 10.00,
                'minimum_order_amount' => 25.00,
                'maximum_discount' => 10.00,
                'usage_limit' => 25,
                'used_count' => 12,
                'per_user_limit' => 1,
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true,
                'is_first_time_only' => true,
                'is_new_customer_only' => true,
                'banner_image' => 'promotions/banners/new_customer_banner.jpg',
                'banner_title' => 'New Customer Special',
                'banner_subtitle' => '$10 OFF First Order',
                'banner_link' => '/register',
                'banner_position' => 'sidebar',
                'banner_is_active' => true,
            ],
            [
                'name' => 'Buy 2 Get 1 Free',
                'code' => 'B2G1FREE',
                'description' => 'Buy any 2 items and get 1 item of equal or lesser value for free.',
                'type' => 'buy_one_get_one',
                'discount_value' => 0.00,
                'minimum_order_amount' => 0.00,
                'maximum_discount' => null,
                'usage_limit' => 15,
                'used_count' => 8,
                'per_user_limit' => 1,
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->addDays(5),
                'is_active' => false, // Paused
                'is_first_time_only' => false,
                'is_new_customer_only' => false,
                'banner_image' => 'promotions/banners/b2g1_banner.jpg',
                'banner_title' => 'Buy 2 Get 1 Free',
                'banner_subtitle' => 'Limited Time Offer',
                'banner_link' => '/categories',
                'banner_position' => 'category_banner',
                'banner_is_active' => false,
            ],
            [
                'name' => 'Flash Sale - Electronics',
                'code' => 'FLASH50',
                'description' => 'Flash sale on electronics. 50% off for the next 24 hours only!',
                'type' => 'flash_sale',
                'discount_value' => 50.00,
                'minimum_order_amount' => 100.00,
                'maximum_discount' => 200.00,
                'usage_limit' => 30,
                'used_count' => 18,
                'per_user_limit' => 1,
                'start_date' => Carbon::now()->subHours(12),
                'end_date' => Carbon::now()->addHours(12),
                'is_active' => true,
                'is_first_time_only' => false,
                'is_new_customer_only' => false,
                'banner_image' => 'promotions/banners/flash_sale_banner.jpg',
                'banner_title' => 'Flash Sale - Electronics',
                'banner_subtitle' => '50% OFF - 24 Hours Only',
                'banner_link' => '/categories/electronics',
                'banner_position' => 'top',
                'banner_is_active' => true,
            ],
            [
                'name' => 'Holiday Special',
                'code' => 'HOLIDAY25',
                'description' => 'Holiday season special discount. 25% off on all items.',
                'type' => 'percentage',
                'discount_value' => 25.00,
                'minimum_order_amount' => 75.00,
                'maximum_discount' => 150.00,
                'usage_limit' => null, // Unlimited
                'used_count' => 67,
                'per_user_limit' => 2,
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(45),
                'is_active' => true,
                'is_first_time_only' => false,
                'is_new_customer_only' => false,
                'banner_image' => 'promotions/banners/holiday_banner.jpg',
                'banner_title' => 'Holiday Special',
                'banner_subtitle' => '25% OFF Everything',
                'banner_link' => '/products',
                'banner_position' => 'footer',
                'banner_is_active' => false, // Scheduled
            ],
        ];

        foreach ($promotions as $promotionData) {
            Promotion::create($promotionData);
        }

        $this->command->info('Sample promotions seeded successfully!');
    }
}
