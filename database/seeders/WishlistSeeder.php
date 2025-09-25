<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\Product;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get some users and products for testing
        $users = User::where('role', 'user')->take(5)->get();
        $products = Product::where('status', 'active')->take(10)->get();

        if ($users->count() > 0 && $products->count() > 0) {
            foreach ($users as $user) {
                // Add 2-5 random products to each user's wishlist
                $randomProducts = $products->random(rand(2, min(5, $products->count())));
                
                foreach ($randomProducts as $product) {
                    Wishlist::firstOrCreate([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'vendor_id' => $product->vendor_id,
                    ]);
                }
            }
        }
    }
}
