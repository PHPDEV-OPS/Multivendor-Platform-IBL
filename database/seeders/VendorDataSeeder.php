<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create or find vendor user
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@example.com'],
            [
                'name' => 'Tech Vendor',
                'password' => Hash::make(env('SEEDER_DEFAULT_PASSWORD', 'ChangeMe123!')),
                'role' => 'vendor',
                'is_active' => true,
            ]
        );

        // Create or find customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Customer',
                'password' => Hash::make(env('SEEDER_DEFAULT_PASSWORD', 'ChangeMe123!')),
                'role' => 'user',
                'is_active' => true,
            ]
        );

        // Create or find categories
        $electronicsCategory = Category::firstOrCreate(
            ['slug' => 'electronics'],
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
            ]
        );

        $beautyCategory = Category::firstOrCreate(
            ['slug' => 'beauty-personal-care'],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Beauty and personal care products',
                'is_active' => true,
            ]
        );

        // Create products for the vendor
        $products = [
            [
                'name' => 'Nova Hair Shaving Machine',
                'slug' => 'nova-hair-shaving-machine',
                'description' => 'Professional hair shaving machine for barbers and salons',
                'short_description' => 'High-quality hair shaving machine',
                'sku' => 'NOVA-001',
                'price' => 1500.00,
                'sale_price' => 1200.00,
                'stock_quantity' => 25,
                'min_stock_alert' => 5,
                'main_image' => 'frontend/amazy/img/67b5a3c9e4224.png',
                'status' => 'active',
                'sold_count' => 45,
                'rating' => 4.8,
                'review_count' => 12,
            ],
            [
                'name' => 'Ceriotti Hair Dryer',
                'slug' => 'ceriotti-hair-dryer',
                'description' => 'Professional hair dryer with multiple heat settings',
                'short_description' => 'Professional hair dryer',
                'sku' => 'CERI-002',
                'price' => 3500.00,
                'sale_price' => 2800.00,
                'stock_quantity' => 3, // Low stock for testing
                'min_stock_alert' => 5,
                'main_image' => 'frontend/amazy/img/67b5a3c9e4224.png',
                'status' => 'active',
                'sold_count' => 32,
                'rating' => 4.6,
                'review_count' => 8,
            ],
            [
                'name' => 'Beard Trimmer Pro',
                'slug' => 'beard-trimmer-pro',
                'description' => 'Professional beard trimmer with adjustable settings',
                'short_description' => 'Professional beard trimmer',
                'sku' => 'BEARD-003',
                'price' => 1200.00,
                'sale_price' => 950.00,
                'stock_quantity' => 15,
                'min_stock_alert' => 5,
                'main_image' => 'frontend/amazy/img/67b5a3c9e4224.png',
                'status' => 'active',
                'sold_count' => 28,
                'rating' => 4.9,
                'review_count' => 15,
            ],
            [
                'name' => 'Hair Clipper Set',
                'slug' => 'hair-clipper-set',
                'description' => 'Complete hair clipper set with multiple attachments',
                'short_description' => 'Complete hair clipper set',
                'sku' => 'CLIP-004',
                'price' => 2500.00,
                'sale_price' => 2000.00,
                'stock_quantity' => 8,
                'min_stock_alert' => 5,
                'main_image' => 'frontend/amazy/img/67b5a3c9e4224.png',
                'status' => 'active',
                'sold_count' => 18,
                'rating' => 4.7,
                'review_count' => 6,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::firstOrCreate(
                ['sku' => $productData['sku']],
                array_merge($productData, [
                    'vendor_id' => $vendor->id,
                    'category_id' => $beautyCategory->id,
                ])
            );

            // Create some reviews for each product (only if product was just created)
            if ($product->wasRecentlyCreated) {
                for ($i = 0; $i < rand(3, 8); $i++) {
                    Review::create([
                        'user_id' => $customer->id,
                        'product_id' => $product->id,
                        'rating' => rand(4, 5),
                        'title' => 'Great product!',
                        'comment' => 'This is an excellent product. Highly recommended!',
                        'is_verified_purchase' => true,
                        'is_approved' => true,
                    ]);
                }
            }
        }

        // Create orders
        $orderStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        $paymentStatuses = ['pending', 'paid'];

        // Only create orders if they don't already exist
        $existingOrders = Order::where('vendor_id', $vendor->id)->count();
        if ($existingOrders == 0) {
            for ($i = 1; $i <= 15; $i++) {
                $order = Order::create([
                    'order_number' => 'ORD-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => $customer->id,
                    'vendor_id' => $vendor->id,
                    'subtotal' => rand(1000, 5000),
                    'tax_amount' => 0,
                    'shipping_amount' => 200,
                    'discount_amount' => 0,
                    'total_amount' => rand(1200, 5200),
                    'commission_amount' => rand(100, 500),
                    'vendor_amount' => rand(1100, 4700),
                    'status' => $orderStatuses[array_rand($orderStatuses)],
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'payment_method' => 'M-Pesa',
                    'shipping_address' => '123 Main St, Nairobi, Kenya',
                    'billing_address' => '123 Main St, Nairobi, Kenya',
                    'shipping_method' => 'Standard Delivery',
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                // Create order items
                $product = Product::where('vendor_id', $vendor->id)->inRandomOrder()->first();
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'product_image' => $product->main_image,
                        'quantity' => rand(1, 3),
                        'unit_price' => $product->final_price,
                        'total_price' => $product->final_price * rand(1, 3),
                    ]);
                }
            }
        }

        $this->command->info('Vendor data seeded successfully!');
        $this->command->info('Vendor email: vendor@example.com');
        $this->command->info('Vendor password: ' . env('SEEDER_DEFAULT_PASSWORD', 'ChangeMe123!'));
    }
}
