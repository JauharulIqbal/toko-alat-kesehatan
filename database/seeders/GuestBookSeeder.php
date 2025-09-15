<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuestBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guestBook = [
            [
                'id_guest_book' => 'e3fc76e2-872b-4525-bbe3-74614f40ab19',
                'nama' => 'Dr. Andika Putra',
                'email' => 'dr.andika@rumahsakit.com',
                'message' => 'Website yang sangat membantu dalam mencari alat kesehatan berkualitas. Katalog produk lengkap dan informatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_guest_book' => 'f65bb266-8041-4c0a-ba20-186f0f25c1f4',
                'nama' => 'Perawat Sinta',
                'email' => 'sinta.perawat@klinik.co.id',
                'message' => 'Pelayanan sangat memuaskan. Proses pembelian mudah dan pengiriman cepat. Sangat direkomendasikan untuk tenaga medis.',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id_guest_book' => '6a57da6d-3423-4612-92ec-d192382a2c1c',
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'message' => 'Terima kasih atas pelayanan yang prima. Alat kesehatan yang dibeli sesuai dengan deskripsi dan kualitas terjamin.',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'id_guest_book' => 'b6dcb6fa-d32a-468f-a53f-e968eccbe6f5',
                'nama' => 'Ibu Maria',
                'email' => 'maria.healthcare@gmail.com',
                'message' => 'Platform yang user-friendly dengan berbagai pilihan alat kesehatan. Customer service responsif dan membantu.',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'id_guest_book' => '957bb236-d404-4f7e-ab79-d568f0f64aff',
                'nama' => 'Apoteker Rendi',
                'email' => 'rendi.apt@apotek.net',
                'message' => 'Sangat membantu dalam pengadaan alat kesehatan untuk apotek. Harga kompetitif dan produk berkualitas tinggi.',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
        ];

        DB::table('guest_book')->insert($guestBook);
    }
}