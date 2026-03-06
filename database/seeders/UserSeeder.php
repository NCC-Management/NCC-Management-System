<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cadet;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create multiple cadet users for testing
        $cadets = [
            [
                'email' => 'cadet@example.com',
                'name' => 'Test Cadet',
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'john@example.com',
                'name' => 'John Cadet',
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'sarah@example.com',
                'name' => 'Sarah Cadet',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($cadets as $cadetData) {
            $user = User::updateOrCreate(
                ['email' => $cadetData['email']],
                [
                    'name' => $cadetData['name'],
                    'password' => $cadetData['password'],
                    'role' => 'cadet',
                    'phone' => null,
                ]
            );

            // Create associated cadet profile if doesn't exist
            Cadet::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'enrollment_no' => 'NCC' . rand(10000, 99999),
                ]
            );
        }
    }
}