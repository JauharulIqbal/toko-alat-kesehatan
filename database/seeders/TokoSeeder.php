<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kota dan vendor
        $kota = DB::table('kota')->pluck('id_kota')->toArray();
        $vendors = DB::table('users')->where('role', 'vendor')->pluck('id_user')->toArray();

        $toko = [
            [
                'id_toko' => 'd1c68ac4-9f57-4b54-9e49-44bb10ed5b23',
                'nama_toko' => 'Alkes Medis Prima',
                'deskripsi_toko' => 'Toko alat kesehatan terpercaya dengan berbagai macam peralatan medis berkualitas tinggi untuk rumah sakit dan klinik.',
                'alamat_toko' => 'Jl. Kesehatan No. 10, Jakarta Pusat',
                'id_kota' => '0401bc0e-8f4e-4162-89f0-a6a020d5e4dc',
                'id_user' => '8f653859-3df0-47c4-a280-58255c9c9f7e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_toko' => 'd4f5125a-9ccf-4d97-ab1e-8a729ae8813a',
                'nama_toko' => 'Medical Store Bandung',
                'deskripsi_toko' => 'Penyedia alat kesehatan lengkap dan terjangkau untuk kebutuhan medis profesional maupun personal.',
                'alamat_toko' => 'Jl. Sehat Sentosa No. 25, Bandung',
                'id_kota' => '0401bc0e-8f4e-4162-89f0-a6a020d5e4dc',
                'id_user' => '7191dd85-d433-415d-9f15-187e5750093e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_toko' => 'e43acd13-489f-4c6e-b8fe-1917b0dadf8a',
                'nama_toko' => 'Yogya Health Equipment',
                'deskripsi_toko' => 'Distributor resmi alat-alat kesehatan modern dengan harga kompetitif dan layanan after sales terbaik.',
                'alamat_toko' => 'Jl. Malioboro Health Center No. 15, Yogyakarta',
                'id_kota' => '0401bc0e-8f4e-4162-89f0-a6a020d5e4dc',
                'id_user' => '6cb54e2b-723f-4644-98dd-848083de7e58',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('toko')->insert($toko);
    }
}