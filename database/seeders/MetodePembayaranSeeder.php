<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodePembayaran = [
            [
                'id_metode_pembayaran' => '4fa9e17f-f0a2-4793-9f37-b1a83b4f8a33',
                'metode_pembayaran' => 'Transfer Bank BCA',
                'tipe_pembayaran' => 'prepaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_metode_pembayaran' => '822e3b48-3f5a-4b32-8dfb-d83339c5f943',
                'metode_pembayaran' => 'Transfer Bank Mandiri',
                'tipe_pembayaran' => 'prepaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_metode_pembayaran' => '7c92bb60-e08d-4c0b-83d5-733ce87d8595',
                'metode_pembayaran' => 'E-Wallet OVO',
                'tipe_pembayaran' => 'prepaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_metode_pembayaran' => 'b6b3a76c-4f75-42a7-b326-adad40831d74',
                'metode_pembayaran' => 'E-Wallet GoPay',
                'tipe_pembayaran' => 'prepaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_metode_pembayaran' => 'c7b3e233-4607-450c-8bc8-5f7685fb5392',
                'metode_pembayaran' => 'Cash on Delivery (COD)',
                'tipe_pembayaran' => 'postpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('metode_pembayaran')->insert($metodePembayaran);
    }
}