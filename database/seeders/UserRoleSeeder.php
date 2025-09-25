<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@tununue.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'phone' => '+254700000001',
            'address' => 'Admin Office, Nairobi',
            'city' => 'Nairobi',
            'state' => 'Nairobi County',
            'postal_code' => '00100',
            'country' => 'Kenya',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Vendor User
        User::create([
            'name' => 'Vendor Store',
            'email' => 'vendor@tununue.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_VENDOR,
            'phone' => '+254700000002',
            'address' => 'Vendor Store, Mombasa',
            'city' => 'Mombasa',
            'state' => 'Mombasa County',
            'postal_code' => '80100',
            'country' => 'Kenya',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Customer User
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@tununue.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CUSTOMER,
            'phone' => '+254700000003',
            'address' => '123 Customer Street, Kisumu',
            'city' => 'Kisumu',
            'state' => 'Kisumu County',
            'postal_code' => '40100',
            'country' => 'Kenya',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
