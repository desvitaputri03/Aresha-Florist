<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDataSeeder extends Seeder
{
    public function run(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
        }

        // Insert Products
        DB::table('products')->insert([
            [
                'id' => 9,
                'name' => 'Karangan Bunga Box',
                'deskripsi' => null,
                'harga' => 130000.00,
                'harga_diskon' => null,
                'id_kategori' => 12,
                'gambar' => null,
                'stok' => 12,
                'is_combinable' => 0,
                'combinable_multiplier' => null,
                'created_at' => '2026-01-03 08:20:37',
                'updated_at' => '2026-01-03 08:20:37',
            ],
            [
                'id' => 10,
                'name' => 'Papan Bunga Wisuda Premium',
                'deskripsi' => null,
                'harga' => 220000.00,
                'harga_diskon' => null,
                'id_kategori' => 11,
                'gambar' => null,
                'stok' => 15,
                'is_combinable' => 0,
                'combinable_multiplier' => null,
                'created_at' => '2026-01-03 08:23:41',
                'updated_at' => '2026-01-03 08:23:41',
            ],
            [
                'id' => 11,
                'name' => 'Papan Rustic Wisuda',
                'deskripsi' => 'Kayu kokoh dan bahan tahan lama.',
                'harga' => 150000.00,
                'harga_diskon' => null,
                'id_kategori' => 10,
                'gambar' => null,
                'stok' => 25,
                'is_combinable' => 0,
                'combinable_multiplier' => null,
                'created_at' => '2026-01-03 08:30:25',
                'updated_at' => '2026-01-03 08:31:24',
            ],
            [
                'id' => 12,
                'name' => 'Papan Bunga Dukacita',
                'deskripsi' => 'Papan bunga dukacita bergaya rustic yang dirangkai dengan sentuhan alami dan elegan untuk menyampaikan rasa belasungkawa secara tulus.',
                'harga' => 150000.00,
                'harga_diskon' => null,
                'id_kategori' => 10,
                'gambar' => null,
                'stok' => 23,
                'is_combinable' => 0,
                'combinable_multiplier' => null,
                'created_at' => '2026-01-03 08:40:17',
                'updated_at' => '2026-01-03 08:40:17',
            ],
            [
                'id' => 13,
                'name' => 'Papan Bunga Selamat Wisuda',
                'deskripsi' => null,
                'harga' => 130000.00,
                'harga_diskon' => 13.00,
                'id_kategori' => 12,
                'gambar' => null,
                'stok' => 30,
                'is_combinable' => 0,
                'combinable_multiplier' => null,
                'created_at' => '2026-01-03 08:44:00',
                'updated_at' => '2026-01-03 08:44:00',
            ],
        ]);

        // Insert Product Images
        DB::table('product_images')->insert([
            [
                'id' => 13,
                'product_id' => 9,
                'image_path' => 'products/lRc0q4MYukLvX4T4LTb1DUJcqYBXhHtH2MvYpQnD.jpg',
                'order' => 0,
                'created_at' => '2026-01-03 08:20:37',
                'updated_at' => '2026-01-03 08:20:37',
            ],
            [
                'id' => 14,
                'product_id' => 10,
                'image_path' => 'products/PwaqiqTJN27H0IowdljjK1pW56XjCF86vDqjWcjK.jpg',
                'order' => 0,
                'created_at' => '2026-01-03 08:23:41',
                'updated_at' => '2026-01-03 08:23:41',
            ],
            [
                'id' => 15,
                'product_id' => 11,
                'image_path' => 'products/0NZje1zG6LdB4T7zrOqfJQfNwoqwZJZNhdH6YsvH.jpg',
                'order' => 0,
                'created_at' => '2026-01-03 08:30:25',
                'updated_at' => '2026-01-03 08:30:25',
            ],
            [
                'id' => 16,
                'product_id' => 12,
                'image_path' => 'products/25Z3OFj3hQICbXht5RelK4lgG5Ct2gqAEXhhSdVy.jpg',
                'order' => 0,
                'created_at' => '2026-01-03 08:40:17',
                'updated_at' => '2026-01-03 08:40:17',
            ],
            [
                'id' => 17,
                'product_id' => 13,
                'image_path' => 'products/5RFGtXwJEtLKtWJKLOqDMsLcxnIM79YOrU2Uf9Q0.jpg',
                'order' => 0,
                'created_at' => '2026-01-03 08:44:01',
                'updated_at' => '2026-01-03 08:44:01',
            ],
        ]);

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON');
        }
    }
}
