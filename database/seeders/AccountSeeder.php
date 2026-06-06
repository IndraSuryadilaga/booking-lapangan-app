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
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@booking.com'],
            [
                'name' => 'Test Regular User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $jumlahUser = 20;
        $this->command->info("Men-generate {$jumlahUser} Regular Users...");

        User::factory($jumlahUser)->create([
            'role' => 'user',
        ]);

        $this->command->info("AccountSeeder selesai! Super Admin dan User berhasil disiapkan.");
    }
}
