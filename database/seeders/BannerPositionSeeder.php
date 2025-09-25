<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;

class BannerPositionSeeder extends Seeder
{
    public function run()
    {
        // Copy existing images to create banners for all positions
        $sourceImages = [
            'public/uploads/images/22-02-2025/67b9bb216a143.webp',
            'public/uploads/images/22-02-2025/67b9bb218e315.webp',
            'public/uploads/images/22-02-2025/67b9bb21db6a0.webp',
            'public/uploads/images/22-02-2025/67b9bb21f8c31.webp',
            'public/uploads/images/22-02-2025/67b9bb2220e62.webp',
        ];

        $bannerPositions = [
            'home_banner' => [
                [
                    'name' => 'Home Banner 1',
                    'title' => 'Special Offers',
                    'subtitle' => 'Up to 50% Off',
                    'image' => 'home_banner_1.webp'
                ],
                [
                    'name' => 'Home Banner 2', 
                    'title' => 'New Arrivals',
                    'subtitle' => 'Fresh Products',
                    'image' => 'home_banner_2.webp'
                ],
                [
                    'name' => 'Home Banner 3',
                    'title' => 'Flash Sale',
                    'subtitle' => 'Limited Time',
                    'image' => 'home_banner_3.webp'
                ]
            ],
            'sidebar' => [
                [
                    'name' => 'Sidebar Banner',
                    'title' => 'Sidebar Promotion',
                    'subtitle' => 'Special Deals',
                    'image' => 'sidebar_banner.webp'
                ]
            ],
            'footer' => [
                [
                    'name' => 'Footer Banner',
                    'title' => 'Footer Promotion',
                    'subtitle' => 'Stay Connected',
                    'image' => 'footer_banner.webp'
                ]
            ],
            'category_banner' => [
                [
                    'name' => 'Category Banner',
                    'title' => 'Category Deals',
                    'subtitle' => 'Shop Now',
                    'image' => 'category_banner.webp'
                ]
            ],
            'cta_banner' => [
                [
                    'name' => 'CTA Banner (Ads Bar)',
                    'title' => 'Call to Action',
                    'subtitle' => 'Shop Now',
                    'image' => 'cta_banner.webp'
                ]
            ]
        ];

        // Ensure storage directory exists
        if (!Storage::disk('public')->exists('promotions/banners')) {
            Storage::disk('public')->makeDirectory('promotions/banners');
        }

        foreach ($bannerPositions as $position => $banners) {
            foreach ($banners as $index => $bannerData) {
                // Copy image from source
                $sourceImage = $sourceImages[$index % count($sourceImages)];
                $destinationImage = 'promotions/banners/' . $bannerData['image'];
                
                if (file_exists($sourceImage)) {
                    copy($sourceImage, storage_path('app/public/' . $destinationImage));
                }

                // Create or update promotion
                Promotion::updateOrCreate(
                    [
                        'name' => $bannerData['name'],
                        'banner_position' => $position
                    ],
                    [
                        'code' => strtoupper(substr($bannerData['name'], 0, 3)) . rand(100, 999),
                        'banner_title' => $bannerData['title'],
                        'banner_subtitle' => $bannerData['subtitle'],
                        'banner_image' => $destinationImage,
                        'banner_link' => route('categories'),
                        'banner_is_active' => true,
                        'banner_position' => $position,
                        'type' => 'percentage',
                        'discount_value' => rand(10, 50),
                        'start_date' => now(),
                        'end_date' => now()->addMonths(3),
                        'is_active' => true
                    ]
                );
            }
        }

        echo "Banner positions seeded successfully!\n";
    }
}
