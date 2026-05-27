<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Administrator',
            'email' => 'superadmin@booking.com',
            'password' => bcrypt('password'),
            'role' => 'super-admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin Users for 2 venues
        for ($i = 1; $i <= 2; $i++) {
            DB::table('users')->insert([
                'name' => "Admin Venue $i",
                'email' => "admin$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Regular Users for demo booking
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => "Regular User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
