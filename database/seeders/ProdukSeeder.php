<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kategori dan toko
        $kategori = DB::table('kategori')->pluck('id_kategori')->toArray();
        $toko = DB::table('toko')->pluck('id_toko')->toArray();

        $produk = [
            // Produk dari toko pertama
            [
                'id_produk' => '8f04f0ff-18c5-47ae-a0c8-d0f8f729c6e7',
                'nama_produk' => 'Tensimeter Digital',
                'deskripsi' => 'Tensimeter digital otomatis dengan akurasi tinggi untuk mengukur tekanan darah',
                'harga' => 250000.00,
                'stok' => 25,
                'gambar_produk' => 'tensimeter-digital.jpg',
                'id_kategori' => 'b43eca10-b535-4dc5-a8ca-5bd74f302d76', // Alat Diagnostik
                'id_toko' => 'd1c68ac4-9f57-4b54-9e49-44bb10ed5b23',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => 'c733bc2d-6d71-4aeb-a289-886a1e4cf4be',
                'nama_produk' => 'Stetoskop Littmann',
                'deskripsi' => 'Stetoskop premium untuk pemeriksaan jantung dan paru-paru dengan kualitas suara jernih',
                'harga' => 1500000.00,
                'stok' => 15,
                'gambar_produk' => 'stetoskop-littmann.jpg',
                'id_kategori' => 'b43eca10-b535-4dc5-a8ca-5bd74f302d76', // Alat Diagnostik
                'id_toko' => 'd1c68ac4-9f57-4b54-9e49-44bb10ed5b23',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => '0472c823-dd46-4abf-ac53-502dda995d9b',
                'nama_produk' => 'Termometer Infrared',
                'deskripsi' => 'Termometer infrared non-kontak untuk pengukuran suhu tubuh yang cepat dan akurat',
                'harga' => 350000.00,
                'stok' => 30,
                'gambar_produk' => 'termometer-infrared.jpg',
                'id_kategori' => 'b43eca10-b535-4dc5-a8ca-5bd74f302d76', // Alat Diagnostik
                'id_toko' => 'd1c68ac4-9f57-4b54-9e49-44bb10ed5b23',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk dari toko kedua
            [
                'id_produk' => 'f7edcabe-9744-477e-b1f2-b7a09ada51dc',
                'nama_produk' => 'Nebulizer Portabel',
                'deskripsi' => 'Nebulizer portabel untuk terapi pernapasan dengan teknologi mesh terbaru',
                'harga' => 750000.00,
                'stok' => 20,
                'gambar_produk' => 'nebulizer-portabel.jpg',
                'id_kategori' => 'b278e4b2-866c-467c-865b-a4336e220a18', // Alat Terapi
                'id_toko' => 'd4f5125a-9ccf-4d97-ab1e-8a729ae8813a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => '7615b76c-036b-4f5e-a8fb-8585856ecd89',
                'nama_produk' => 'Kursi Roda Lipat',
                'deskripsi' => 'Kursi roda lipat ringan dengan ban anti bocor dan rem tangan yang aman',
                'harga' => 1200000.00,
                'stok' => 10,
                'gambar_produk' => 'kursi-roda-lipat.jpg',
                'id_kategori' => 'b278e4b2-866c-467c-865b-a4336e220a18', // Alat Terapi
                'id_toko' => 'd4f5125a-9ccf-4d97-ab1e-8a729ae8813a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Produk dari toko ketiga
            [
                'id_produk' => '35e6f83b-67b5-4a1a-826e-445cd11ca160',
                'nama_produk' => 'Set Alat Bedah Minor',
                'deskripsi' => 'Set lengkap alat bedah minor terdiri dari gunting, pinset, dan scalpel steril',
                'harga' => 450000.00,
                'stok' => 12,
                'gambar_produk' => 'set-alat-bedah.jpg',
                'id_kategori' => '8d52f072-ab17-4d2c-8245-b3713ee9f748', // Alat Bedah
                'id_toko' => 'e43acd13-489f-4c6e-b8fe-1917b0dadf8a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => 'fdacdc2d-88eb-42b9-83ce-50b5a62eeb8b',
                'nama_produk' => 'Mikroskop Binokular',
                'deskripsi' => 'Mikroskop binokular dengan perbesaran hingga 1000x untuk keperluan laboratorium',
                'harga' => 2500000.00,
                'stok' => 5,
                'gambar_produk' => 'mikroskop-binokular.jpg',
                'id_kategori' => 'f140e3cc-b795-4a59-bb76-f1afc06b4994', // Alat Laboratorium
                'id_toko' => 'e43acd13-489f-4c6e-b8fe-1917b0dadf8a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => '1bfd4905-584a-46fe-a4ea-cb127e1b851f',
                'nama_produk' => 'Masker N95 Box',
                'deskripsi' => 'Masker N95 original dalam kemasan box isi 20 pcs untuk perlindungan maksimal',
                'harga' => 150000.00,
                'stok' => 50,
                'gambar_produk' => 'masker-n95-box.jpg',
                'id_kategori' => '737bc43e-bcba-4a0d-bff1-13a071dc1bb9', // Perlengkapan Medis
                'id_toko' => 'e43acd13-489f-4c6e-b8fe-1917b0dadf8a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => '5c7ed41b-0fbe-40eb-a30b-7c499d60dad7',
                'nama_produk' => 'Hand Sanitizer 500ml',
                'deskripsi' => 'Hand sanitizer antiseptik dengan kandungan alkohol 70% dalam botol pump 500ml',
                'harga' => 45000.00,
                'stok' => 100,
                'gambar_produk' => 'hand-sanitizer-500ml.jpg',
                'id_kategori' => '737bc43e-bcba-4a0d-bff1-13a071dc1bb9', // Perlengkapan Medis
                'id_toko' => 'd4f5125a-9ccf-4d97-ab1e-8a729ae8813a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('produk')->insert($produk);
    }
}