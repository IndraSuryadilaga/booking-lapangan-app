<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@booking.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'super-admin',
            ]
        );

        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "admin{$i}@example.com"],
                [
                    'name' => "Admin Venue {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                ]
            );
        }

        for ($i = 1; $i <= 10; $i++) {
            User::firstOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => "Regular User {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]
            );
        }
    }
}
