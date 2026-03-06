<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create primary admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1234567890',
            ]
        );

        // Create secondary admin user (for testing)
        User::firstOrCreate(
            ['email' => 'yash@gmail.com'],
            [
                'name' => 'Yash Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1987654321',
            ]
        );

        echo "✅ Admin users created/verified!\n";
        echo "Admin 1: admin@example.com (password: password)\n";
        echo "Admin 2: yash@gmail.com (password: password)\n";
    }
}
