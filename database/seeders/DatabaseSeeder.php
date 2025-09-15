<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TokoSeeder::class,
            ProdukSeeder::class,
            KotaSeeder::class,
            KategoriSeeder::class,
            MetodePembayaranSeeder::class,
            JasaPengirimanSeeder::class,
            FeedbackSeeder::class,
            GuestBookSeeder::class,
        ]);
    }
}
