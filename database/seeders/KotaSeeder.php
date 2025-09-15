<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kota = [
            [
                'id_kota' => '56deac72-1df4-4802-a6eb-bc58bfd5b7c1',
                'nama_kota' => 'Surabaya',
                'kode_kota' => 'SBY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kota' => 'a959529a-e4f0-4365-856f-cb6c09d6e4a4',
                'nama_kota' => 'Jakarta',
                'kode_kota' => 'JKT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kota' => '0401bc0e-8f4e-4162-89f0-a6a020d5e4dc',
                'nama_kota' => 'Bandung',
                'kode_kota' => 'BDG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kota' => '925f4667-2244-42ee-bd60-fbc480b68ec3',
                'nama_kota' => 'Yogyakarta',
                'kode_kota' => 'YGY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kota' => 'b3d4ebf5-c709-4137-a78c-a2faa2eaf5df',
                'nama_kota' => 'Semarang',
                'kode_kota' => 'SMG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('kota')->insert($kota);
    }
}