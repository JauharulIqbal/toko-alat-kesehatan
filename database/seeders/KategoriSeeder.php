<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'id_kategori' => 'b43eca10-b535-4dc5-a8ca-5bd74f302d76',
                'nama_kategori' => 'Alat Diagnostik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 'b278e4b2-866c-467c-865b-a4336e220a18',
                'nama_kategori' => 'Alat Terapi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => '8d52f072-ab17-4d2c-8245-b3713ee9f748',
                'nama_kategori' => 'Alat Bedah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 'f140e3cc-b795-4a59-bb76-f1afc06b4994',
                'nama_kategori' => 'Alat Laboratorium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => '737bc43e-bcba-4a0d-bff1-13a071dc1bb9',
                'nama_kategori' => 'Perlengkapan Medis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('kategori')->insert($kategori);
    }
}