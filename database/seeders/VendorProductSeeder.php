<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class VendorProductSeeder extends Seeder
{
    public function run()
    {
        // Create a vendor user if it doesn't exist
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@example.com'],
            [
                'name' => 'Sample Vendor',
                'email' => 'vendor@example.com',
                'password' => bcrypt(env('SEEDER_DEFAULT_PASSWORD', 'ChangeMe123!')),
                'role' => 'vendor',
                'email_verified_at' => now(),
            ]
        );

        // Create categories
        $categories = [
            'Electronics' => [
                'description' => 'Electronic devices and gadgets',
                'children' => [
                    'Smartphones' => 'Mobile phones and accessories',
                    'Laptops' => 'Portable computers and accessories',
                    'Audio' => 'Headphones, speakers, and audio equipment',
                ]
            ],
            'Beauty & Personal Care' => [
                'description' => 'Beauty products and personal care items',
                'children' => [
                    'Hair Care' => 'Hair products and accessories',
                    'Skin Care' => 'Facial and body care products',
                    'Makeup' => 'Cosmetics and beauty tools',
                ]
            ],
            'Home & Garden' => [
                'description' => 'Home improvement and garden supplies',
                'children' => [
                    'Kitchen' => 'Kitchen appliances and utensils',
                    'Furniture' => 'Home and office furniture',
                    'Garden' => 'Garden tools and plants',
                ]
            ],
            'Fashion' => [
                'description' => 'Clothing, shoes, and accessories',
                'children' => [
                    'Men\'s Clothing' => 'Clothing for men',
                    'Women\'s Clothing' => 'Clothing for women',
                    'Shoes' => 'Footwear for all ages',
                ]
            ],
        ];

        foreach ($categories as $categoryName => $categoryData) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                [
                    'slug' => Str::slug($categoryName),
                    'description' => $categoryData['description'],
                    'is_active' => true,
                    'sort_order' => 1,
                ]
            );

            // Create subcategories
            foreach ($categoryData['children'] as $childName => $childDescription) {
                Category::firstOrCreate(
                    ['name' => $childName],
                    [
                        'slug' => Str::slug($childName),
                        'description' => $childDescription,
                        'parent_id' => $category->id,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            }
        }

        // Create sample products
        $products = [
            [
                'name' => 'Nova Hair Shaving Machine And Beard Trimmer (Rechargeable)',
                'category' => 'Hair Care',
                'price' => 1000,
                'sale_price' => 800,
                'stock_quantity' => 50,
                'is_featured' => true,
                'is_new' => true,
                'description' => 'Professional rechargeable hair shaving machine with beard trimmer. Perfect for home use with multiple length settings.',
                'short_description' => 'Rechargeable hair shaver with beard trimmer',
            ],
            [
                'name' => 'Ceriotti Super GEK 3000 Blow Dry Hair Dryer - Black',
                'category' => 'Hair Care',
                'price' => 2500,
                'sale_price' => 2000,
                'stock_quantity' => 30,
                'is_bestseller' => true,
                'description' => 'Professional hair dryer with multiple heat settings and cool shot function. Perfect for salon and home use.',
                'short_description' => 'Professional hair dryer with multiple settings',
            ],
            [
                'name' => 'Professional Beard Trimmer - Rechargeable Hair Clipper',
                'category' => 'Hair Care',
                'price' => 800,
                'stock_quantity' => 0,
                'description' => 'Professional beard trimmer with rechargeable battery. Multiple length settings for precise trimming.',
                'short_description' => 'Rechargeable beard trimmer with multiple settings',
            ],
            [
                'name' => 'Hair Clipper Set - Professional Hair Cutting Kit',
                'category' => 'Hair Care',
                'price' => 1200,
                'stock_quantity' => 25,
                'is_featured' => true,
                'description' => 'Complete professional hair cutting kit with multiple guards and accessories. Perfect for home and salon use.',
                'short_description' => 'Complete hair cutting kit with accessories',
            ],
            [
                'name' => 'Smart LED TV 55" 4K Ultra HD',
                'category' => 'Smartphones',
                'price' => 45000,
                'sale_price' => 40000,
                'stock_quantity' => 10,
                'is_featured' => true,
                'description' => '55-inch 4K Ultra HD Smart LED TV with built-in WiFi and multiple streaming apps.',
                'short_description' => '55" 4K Smart LED TV with WiFi',
            ],
            [
                'name' => 'Wireless Bluetooth Headphones',
                'category' => 'Audio',
                'price' => 1500,
                'sale_price' => 1200,
                'stock_quantity' => 40,
                'is_new' => true,
                'description' => 'High-quality wireless Bluetooth headphones with noise cancellation and long battery life.',
                'short_description' => 'Wireless Bluetooth headphones with noise cancellation',
            ],
            [
                'name' => 'Laptop Stand Adjustable Aluminum',
                'category' => 'Laptops',
                'price' => 800,
                'stock_quantity' => 60,
                'description' => 'Adjustable aluminum laptop stand for better ergonomics and cooling.',
                'short_description' => 'Adjustable aluminum laptop stand',
            ],
            [
                'name' => 'Kitchen Blender 1000W Professional',
                'category' => 'Kitchen',
                'price' => 3000,
                'sale_price' => 2500,
                'stock_quantity' => 20,
                'is_bestseller' => true,
                'description' => 'Professional 1000W kitchen blender with multiple speed settings and durable blades.',
                'short_description' => '1000W professional kitchen blender',
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            if ($category) {
                Product::firstOrCreate(
                    ['name' => $productData['name']],
                    [
                        'vendor_id' => $vendor->id,
                        'category_id' => $category->id,
                        'slug' => Str::slug($productData['name']),
                        'description' => $productData['description'],
                        'short_description' => $productData['short_description'],
                        'sku' => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $productData['name']), 0, 3)) . '-' . time(),
                        'price' => $productData['price'],
                        'sale_price' => $productData['sale_price'] ?? null,
                        'stock_quantity' => $productData['stock_quantity'],
                        'min_stock_alert' => 5,
                        'main_image' => 'frontend/amazy/img/67b5a3c9e4224.png',
                        'status' => 'active',
                        'is_featured' => $productData['is_featured'] ?? false,
                        'is_bestseller' => $productData['is_bestseller'] ?? false,
                        'is_new' => $productData['is_new'] ?? false,
                        'weight' => rand(100, 2000) / 100,
                        'length' => rand(10, 50),
                        'width' => rand(10, 50),
                        'height' => rand(10, 50),
                    ]
                );
            }
        }

        $this->command->info('Vendor products seeded successfully!');
    }
}
