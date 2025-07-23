<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin123'),
            'remember_token' => Str::random(10),
            'role' => 'superadmin',
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        // User Biasa
        User::create([
            'name' => 'Farhan',
            'email' => 'farhanvirenze18@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('farhan123'),
            'nik' => '20220140139',
            'nomor_telepon' => '087817184079',
            'remember_token' => Str::random(10),
            'role' => 'user',
        ]);
    }
}
