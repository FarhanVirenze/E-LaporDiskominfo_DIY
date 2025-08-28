<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class WbsAdminSeeder extends Seeder
{
    public function run(): void
    {
        // WBS Admin
        User::create([
            'name' => 'WBS Admin',
            'email' => 'wbsadmin@gmail.com',
            'nik' => '20220140131', // beda dengan superadmin biar unique
            'nomor_telepon' => '087817182321',
            'email_verified_at' => now(),
            'password' => Hash::make('wbsadmin123'),
            'remember_token' => Str::random(10),
            'role' => 'wbs_admin',
        ]);

    }
}
