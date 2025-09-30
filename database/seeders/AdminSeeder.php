<?php

namespace Database\Seeders;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or find default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('SEEDER_DEFAULT_PASSWORD', 'ChangeMe123!')),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create admin profile if it doesn't exist
        AdminProfile::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'admin_code' => 'ADMIN001',
                'department' => 'Management',
                'position' => 'Super Administrator',
                'permissions' => [
                    'users' => ['view', 'create', 'edit', 'delete'],
                    'products' => ['view', 'create', 'edit', 'delete'],
                    'orders' => ['view', 'create', 'edit', 'delete'],
                    'vendors' => ['view', 'create', 'edit', 'delete'],
                    'reports' => ['view', 'export'],
                    'settings' => ['view', 'edit'],
                ],
                'is_super_admin' => true,
            ]
        );
    }
}
