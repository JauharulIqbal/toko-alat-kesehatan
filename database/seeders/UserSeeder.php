<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kota
        $kota = DB::table('kota')->pluck('id_kota')->toArray();

        $users = [
            // Admin
            [
                'id_user' => 'fb4c7117-3cd7-4a25-90ce-65fff3ed3501',
                'name' => 'admin',
                'email' => 'admin@tokoalkes.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567890',
                'alamat' => 'Jl. Admin No. 1, Surabaya',
                'date_of_birth' => '1998-09-15',
                'gender' => 'laki-laki',
                'role' => 'admin',
                'id_kota' => '56deac72-1df4-4802-a6eb-bc58bfd5b7c1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // penjual 1
            [
                'id_user' => '8f653859-3df0-47c4-a280-58255c9c9f7e',
                'name' => 'penjual1',
                'email' => 'penjual1@tokoalkes.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567891',
                'alamat' => 'Jl. penjual Satu No. 10, Jakarta',
                'date_of_birth' => '1990-03-20',
                'gender' => 'laki-laki',
                'role' => 'penjual',
                'id_kota' => '56deac72-1df4-4802-a6eb-bc58bfd5b7c1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // penjual 2
            [
                'id_user' => '7191dd85-d433-415d-9f15-187e5750093e',
                'name' => 'penjual2',
                'email' => 'penjual2@tokoalkes.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567892',
                'alamat' => 'Jl. penjual Dua No. 15, Bandung',
                'date_of_birth' => '2003-06-03',
                'gender' => 'perempuan',
                'role' => 'penjual',
                'id_kota' => '925f4667-2244-42ee-bd60-fbc480b68ec3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // penjual 3
            [
                'id_user' => '6cb54e2b-723f-4644-98dd-848083de7e58',
                'name' => 'penjual3',
                'email' => 'penjual3@tokoalkes.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567893',
                'alamat' => 'Jl. penjual Tiga No. 25, Yogyakarta',
                'date_of_birth' => '1988-10-07',
                'gender' => 'laki-laki',
                'role' => 'penjual',
                'id_kota' => 'a959529a-e4f0-4365-856f-cb6c09d6e4a4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Customer 1
            [
                'id_user' => '9ab8caad-0ec8-4051-84bd-18274b64c14b',
                'name' => 'customer1',
                'email' => 'customer1@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567894',
                'alamat' => 'Jl. Customer Satu No. 5, Surabaya',
                'date_of_birth' => '2009-03-27',
                'gender' => 'perempuan',
                'role' => 'customer',
                'id_kota' => 'a959529a-e4f0-4365-856f-cb6c09d6e4a4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Customer 2
            [
                'id_user' => '0c1a0e01-855d-445c-8f0b-69bfbcf11f08',
                'name' => 'customer2',
                'email' => 'customer2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567895',
                'alamat' => 'Jl. Customer Dua No. 12, Jakarta',
                'date_of_birth' => '2001-03-15',
                'gender' => 'laki-laki',
                'role' => 'customer',
                'id_kota' => 'b3d4ebf5-c709-4137-a78c-a2faa2eaf5df',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Customer 3
            [
                'id_user' => '68a7d0c3-e92a-4bea-b910-8dec676f76ad',
                'name' => 'customer3',
                'email' => 'customer3@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'kontak' => '081234567896',
                'alamat' => 'Jl. Customer Tiga No. 8, Semarang',
                'date_of_birth' => '2010-01-09',
                'gender' => 'perempuan',
                'role' => 'customer',
                'id_kota' => '0401bc0e-8f4e-4162-89f0-a6a020d5e4dc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}