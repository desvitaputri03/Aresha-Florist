<?php

namespace Database\Seeders;

use Database\Seeders\GeoDataSeeder;
use Database\Seeders\CategoryDataSeeder;
use Database\Seeders\ProductDataSeeder;
use Database\Seeders\ImportAllProductImagesSeeder;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan seeding: data geo -> kategori -> produk bawaan -> produk+foto massal -> admin user
        $this->call([
            GeoDataSeeder::class,
            CategoryDataSeeder::class,
            ProductDataSeeder::class,
            ImportAllProductImagesSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
