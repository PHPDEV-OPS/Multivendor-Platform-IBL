<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;

class BannerImageSeeder extends Seeder
{
    public function run()
    {
        // Create real banner promotions with actual images from uploads
        $bannerData = [
            [
                'name' => 'New Arrivals',
                'banner_title' => 'New Arrivals',
                'banner_subtitle' => 'Fresh Products',
                'banner_image' => 'uploads/images/22-02-2025/67b9cf3614f24.gif',
                'banner_position' => 'home_banner',
                'banner_link' => '/categories',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(30),
            ],
            [
                'name' => 'Summer Collection',
                'banner_title' => 'Summer Collection',
                'banner_subtitle' => 'Trendy Styles',
                'banner_image' => 'uploads/images/22-02-2025/67b9bfd32db59.webp',
                'banner_position' => 'home_banner',
                'banner_link' => '/categories',
                'start_date' => now()->subDays(3),
                'end_date' => now()->addDays(25),
            ],
            [
                'name' => 'Special Offers',
                'banner_title' => 'Special Offers',
                'banner_subtitle' => 'Limited Time',
                'banner_image' => 'uploads/images/22-02-2025/67b9bfe9bb5de.webp',
                'banner_position' => 'home_banner',
                'banner_link' => '/products',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(15),
            ],
            [
                'name' => 'Top Deals',
                'banner_title' => 'Top Deals',
                'banner_subtitle' => 'Best Prices',
                'banner_image' => 'uploads/images/22-02-2025/67b9c001dae04.webp',
                'banner_position' => 'home_banner',
                'banner_link' => '/categories',
                'start_date' => now(),
                'end_date' => now()->addDays(20),
            ],
            [
                'name' => 'Flash Sale',
                'banner_title' => 'Flash Sale',
                'banner_subtitle' => '24 Hours Only',
                'banner_image' => 'uploads/images/22-02-2025/67b9c01735d51.webp',
                'banner_position' => 'top',
                'banner_link' => '/products',
                'start_date' => now(),
                'end_date' => now()->addDays(1),
            ],
            [
                'name' => 'Sidebar Promotion',
                'banner_title' => 'Sidebar Promotion',
                'banner_subtitle' => 'Special Discount',
                'banner_image' => 'uploads/images/22-02-2025/67b9c032f17bb.webp',
                'banner_position' => 'sidebar',
                'banner_link' => '/categories',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(18),
            ],
        ];

        foreach ($bannerData as $data) {
            // Check if promotion already exists
            $existingPromotion = Promotion::where('name', $data['name'])->first();
            
            if (!$existingPromotion) {
                Promotion::create([
                    'name' => $data['name'],
                    'code' => strtoupper(str_replace(' ', '', $data['name'])) . rand(100, 999),
                    'description' => 'Banner promotion for ' . $data['name'],
                    'type' => 'percentage',
                    'discount_value' => rand(10, 30),
                    'minimum_order_amount' => rand(20, 100),
                    'maximum_discount' => rand(50, 200),
                    'usage_limit' => rand(50, 200),
                    'used_count' => 0,
                    'per_user_limit' => 1,
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'is_active' => true,
                    'is_first_time_only' => false,
                    'is_new_customer_only' => false,
                    'banner_image' => $data['banner_image'],
                    'banner_title' => $data['banner_title'],
                    'banner_subtitle' => $data['banner_subtitle'],
                    'banner_link' => $data['banner_link'],
                    'banner_position' => $data['banner_position'],
                    'banner_is_active' => true,
                ]);
                
                echo "Created banner promotion: {$data['name']}\n";
            } else {
                // Update existing promotion with banner data
                $existingPromotion->update([
                    'banner_image' => $data['banner_image'],
                    'banner_title' => $data['banner_title'],
                    'banner_subtitle' => $data['banner_subtitle'],
                    'banner_link' => $data['banner_link'],
                    'banner_position' => $data['banner_position'],
                    'banner_is_active' => true,
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'is_active' => true,
                ]);
                
                echo "Updated banner promotion: {$data['name']}\n";
            }
        }

        echo "Banner promotions created/updated successfully!\n";
    }
}
