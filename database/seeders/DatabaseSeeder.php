<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = [
            'Kota Yogyakarta',
            'Kabupaten Sleman',
            'Kabupaten Bantul',
            'Kabupaten Kulon Progo',
            'Kabupaten Gunungkidul',
        ];

        foreach ($wilayah as $nama) {
            WilayahUmum::create([
                'nama' => $nama,
            ]);
        }

        // Superadmin
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'nik' => '20220140130',
            'nomor_telepon' => '087817182358',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin123'),
            'remember_token' => Str::random(10),
            'role' => 'superadmin',
        ]);

        // Users biasa
        $users = [
            ['Farhan', 'farhanvirenze18@gmail.com', 'farhan123', '20220140139', '087817184079'],
            ['Kevin', 'kevin@gmail.com', 'kevin123', '20220140140', '081234567891'],
            ['Bagas Saputra', 'bagas.saputra@gmail.com', 'password123', '20220140141', '082223334455'],
            ['Citra Amelia', 'citra.amelia@gmail.com', 'password123', '20220140142', '083312345678'],
            ['Dedi Pratama', 'dedi.pratama@gmail.com', 'password123', '20220140143', '085678901234'],
            ['Eka Lestari', 'eka.lestari@gmail.com', 'password123', '20220140144', '087701234567'],
        ];

        foreach ($users as [$name, $email, $password, $nik, $phone]) {
            User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'nik' => $nik,
                'nomor_telepon' => $phone,
                'remember_token' => Str::random(10),
                'role' => 'user',
            ]);
        }

        // Seeder OPD dan Kategori Umum
        $opds = [
            ['Dinas Pendidikan DIY', 'Pendidikan'],
            ['Dinas Kesehatan DIY', 'Kesehatan'],
            ['Dinas Sosial DIY', 'Sosial'],
            ['Dinas Kebudayaan DIY', 'Kebudayaan'],
            ['Dinas Perhubungan DIY', 'Transportasi'],
            ['Dinas Pekerjaan Umum DIY', 'Infrastruktur'],
            ['Dinas Lingkungan Hidup DIY', 'Lingkungan'],
            ['Dinas Koperasi dan UKM DIY', 'Koperasi & UKM'],
            ['Dinas Pertanian DIY', 'Pertanian'],
            ['Dinas Pariwisata DIY', 'Pariwisata'],
            ['Dinas Kominfo DIY', 'Informasi dan Teknologi'],
        ];

        foreach ($opds as $index => [$opd_name, $kategori]) {
            $user = User::create([
                'name' => $opd_name,
                'email' => Str::slug($opd_name, '_') . '@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::slug($opd_name, '_')),
                'nomor_telepon' => '08' . rand(1000000000, 9999999999),
                'nik' => '3528' . str_pad((string) ($index + 1), 8, '0', STR_PAD_LEFT),
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ]);

            KategoriUmum::create([
                'nama' => $kategori,
                'admin_id' => $user->id,
            ]);
        }
    }
}
