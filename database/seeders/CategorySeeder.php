<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Beauty products and personal care items',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Fashion',
                'description' => 'Clothing, shoes, and accessories',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Books & Media',
                'description' => 'Books, movies, and music',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car parts and accessories',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Health & Wellness',
                'description' => 'Health supplements and wellness products',
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => $category['is_active'],
                    'is_featured' => $category['is_featured'],
                    'sort_order' => 0,
                ]
            );
        }
    }
}
