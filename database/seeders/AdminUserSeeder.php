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
        // Create a test admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1234567890',
            ]
        );

        // Create a test cadet user
        User::firstOrCreate(
            ['email' => 'cadet@example.com'],
            [
                'name' => 'Test Cadet',
                'password' => Hash::make('password'),
                'role' => 'cadet',
                'phone' => '+0987654321',
            ]
        );

        echo "✅ Admin and Cadet test users created/verified!\n";
        echo "Admin: admin@example.com (password: password)\n";
        echo "Cadet: cadet@example.com (password: password)\n";
    }
}
