<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NomorRekeningPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nomor_rekening_pengguna')->insert([
            [
                'id_nrp' => '13ede355-c638-44f5-a860-36228e3df93f',
                'nomor_rekening' => '123456789012',
                'id_user' => '9ab8caad-0ec8-4051-84bd-18274b64c14b', 
                'id_metode_pembayaran' => '4fa9e17f-f0a2-4793-9f37-b1a83b4f8a33', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_nrp' => '3c900add-ac3c-4297-9a0d-33ed1928515d',
                'nomor_rekening' => '081234567890',
                'id_user' => '9ab8caad-0ec8-4051-84bd-18274b64c14b', 
                'id_metode_pembayaran' => '7c92bb60-e08d-4c0b-83d5-733ce87d8595', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_nrp' => 'b626af67-3229-4694-93a7-95456467a747',
                'nomor_rekening' => '987654321098',
                'id_user' => '0c1a0e01-855d-445c-8f0b-69bfbcf11f08', 
                'id_metode_pembayaran' => '4fa9e17f-f0a2-4793-9f37-b1a83b4f8a33', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
