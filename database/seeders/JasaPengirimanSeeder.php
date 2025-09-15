<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JasaPengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jasaPengiriman = [
            [
                'id_jasa_pengiriman' => '7f56c4f1-a336-457c-87f6-0e33c6546bb0',
                'nama_jasa_pengiriman' => 'JNE Regular',
                'biaya_pengiriman' => 15000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_jasa_pengiriman' => '8626accc-0282-4e6d-a1bc-ab5e4b66c32d',
                'nama_jasa_pengiriman' => 'JNE Express',
                'biaya_pengiriman' => 25000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_jasa_pengiriman' => '18f97051-55a0-41b9-a8df-84754b199ac5',
                'nama_jasa_pengiriman' => 'JT Express',
                'biaya_pengiriman' => 12000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_jasa_pengiriman' => '61ded4b0-db6d-4718-9717-c38ea23e8e64',
                'nama_jasa_pengiriman' => 'SiCepat Reguler',
                'biaya_pengiriman' => 13000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_jasa_pengiriman' => 'bee5c252-8989-4917-8944-159f8d8dca39',
                'nama_jasa_pengiriman' => 'Pos Indonesia',
                'biaya_pengiriman' => 10000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jasa_pengiriman')->insert($jasaPengiriman);
    }
}