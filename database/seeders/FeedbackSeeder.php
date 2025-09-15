<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID toko dan customer
        $toko = DB::table('toko')->pluck('id_toko')->toArray();
        $customers = DB::table('users')->where('role', 'customer')->pluck('id_user')->toArray();

        $feedback = [
            [
                'id_feedback' => '62327939-125b-4226-ad3b-b97a5b35c3f8',
                'nama' => 'Ahmad Rizki',
                'message' => 'Produk berkualitas tinggi dan pengiriman cepat. Sangat puas dengan pelayanan toko ini!',
                'id_toko' => 'd1c68ac4-9f57-4b54-9e49-44bb10ed5b23',
                'id_user' => '9ab8caad-0ec8-4051-84bd-18274b64c14b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_feedback' => '5ad4a150-348a-40da-a58f-93e973f5bc59',
                'nama' => 'Sari Dewi',
                'message' => 'Alat medis yang dibeli sesuai dengan deskripsi. Packaging rapi dan aman. Recommended!',
                'id_toko' => 'd4f5125a-9ccf-4d97-ab1e-8a729ae8813a',
                'id_user' => '0c1a0e01-855d-445c-8f0b-69bfbcf11f08',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_feedback' => '12ddad24-868b-4d18-898a-0f99a74f2ef2',
                'nama' => 'Budi Santoso',
                'message' => 'Harga kompetitif dan customer service responsif. Akan order lagi di masa depan.',
                'id_toko' => 'e43acd13-489f-4c6e-b8fe-1917b0dadf8a',
                'id_user' => '68a7d0c3-e92a-4bea-b910-8dec676f76ad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_feedback' => '6a17388e-462a-4206-b256-7432a7fd455b',
                'nama' => 'Maria Kristina',
                'message' => 'Variasi produk lengkap dan kualitas terjamin. Terima kasih atas pelayanan yang memuaskan.',
                'id_toko' => 'd1c68ac4-9f57-4b54-9e49-44bb10ed5b23',
                'id_user' => '9ab8caad-0ec8-4051-84bd-18274b64c14b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('feedback')->insert($feedback);
    }
}