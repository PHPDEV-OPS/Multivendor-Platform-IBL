<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class TestProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test vendor if not exists
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@test.com'],
            [
                'name' => 'Test Vendor',
                'password' => bcrypt(env('SEEDER_DEFAULT_PASSWORD', 'ChangeMe123!')),
                'email_verified_at' => now(),
            ]
        );

        // Create a test category if not exists
        $category = Category::firstOrCreate(
            ['slug' => 'electronics'],
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'status' => 'active',
                'sort_order' => 1,
            ]
        );

        // Create test products
        $products = [
            [
                'name' => 'Smartphone X',
                'description' => 'Latest smartphone with advanced features',
                'short_description' => 'High-quality smartphone',
                'price' => 25000,
                'sale_price' => 22000,
                'stock_quantity' => 50,
                'sku' => 'PHONE-001',
                'is_featured' => true,
                'is_new' => true,
            ],
            [
                'name' => 'Laptop Pro',
                'description' => 'Professional laptop for work and gaming',
                'short_description' => 'Powerful laptop',
                'price' => 85000,
                'sale_price' => null,
                'stock_quantity' => 25,
                'sku' => 'LAPTOP-001',
                'is_featured' => true,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium wireless headphones with noise cancellation',
                'short_description' => 'High-quality headphones',
                'price' => 12000,
                'sale_price' => 10000,
                'stock_quantity' => 100,
                'sku' => 'HEAD-001',
                'is_featured' => false,
                'is_new' => true,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness and health tracking smartwatch',
                'short_description' => 'Smart fitness watch',
                'price' => 18000,
                'sale_price' => 15000,
                'stock_quantity' => 75,
                'sku' => 'WATCH-001',
                'is_featured' => false,
                'is_bestseller' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['sku' => $productData['sku']],
                array_merge($productData, [
                    'vendor_id' => $vendor->id,
                    'category_id' => $category->id,
                    'slug' => Str::slug($productData['name']),
                    'status' => 'active',
                    'cost_price' => $productData['price'] * 0.7, // 30% margin
                    'main_image' => 'frontend/amazy/img/67b5a3c9e4224.png',
                    'weight' => 0.5,
                    'length' => 10,
                    'width' => 5,
                    'height' => 2,
                    'min_stock_alert' => 10,
                    'view_count' => 0,
                    'sold_count' => 0,
                    'rating' => 4.5,
                    'review_count' => 0,
                ])
            );
        }

        $this->command->info('Test products created successfully!');
    }
}
