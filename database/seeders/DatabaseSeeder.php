<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeders in order
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            SettingsSeeder::class,
            VendorDataSeeder::class, // Add vendor data seeder
            PromotionSeeder::class, // Add promotion seeder
            BannerImageSeeder::class, // Add banner image seeder
            VendorProductSeeder::class, // Add vendor products seeder
        ]);
    }
}
