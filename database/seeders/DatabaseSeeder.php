<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Mawar', 'deskripsi' => 'Bunga mawar segar berkualitas tinggi'],
            ['name' => 'Lily', 'deskripsi' => 'Bunga lily elegan dan harum'],
            ['name' => 'Tulip', 'deskripsi' => 'Bunga tulip warna-warni yang cantik'],
            ['name' => 'Matahari', 'deskripsi' => 'Bunga matahari cerah dan ceria'],
            ['name' => 'Baby Breath', 'deskripsi' => 'Bunga baby breath lembut dan romantis'],
            ['name' => 'Anggrek', 'deskripsi' => 'Bunga anggrek eksotis dan mewah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Buket Bunga Mawar Merah',
                'deskripsi' => 'Love Story Bouquet - 12 tangkai mawar merah segar dengan kemasan elegan',
                'harga' => 1200000,
                'harga_diskon' => 845000,
                'id_kategori' => 1,
                'stok' => 25,
            ],
            [
                'name' => 'Buket Bunga Lily Putih',
                'deskripsi' => 'Pure Elegance Bouquet - 8 tangkai lily putih dengan daun hijau segar',
                'harga' => 750000,
                'harga_diskon' => 650000,
                'id_kategori' => 2,
                'stok' => 18,
            ],
            [
                'name' => 'Buket Bunga Tulip',
                'deskripsi' => 'Spring Joy Bouquet - Campuran tulip warna-warni yang cerah',
                'harga' => 550000,
                'harga_diskon' => null,
                'id_kategori' => 3,
                'stok' => 30,
            ],
            [
                'name' => 'Bunga Box Mawar Pink',
                'deskripsi' => 'Sweet Dreams Box - 6 tangkai mawar pink dalam box elegan',
                'harga' => 425000,
                'harga_diskon' => null,
                'id_kategori' => 1,
                'stok' => 15,
            ],
            [
                'name' => 'Buket Bunga Matahari',
                'deskripsi' => 'Sunshine Bouquet - 5 tangkai matahari kuning cerah',
                'harga' => 375000,
                'harga_diskon' => null,
                'id_kategori' => 4,
                'stok' => 22,
            ],
            [
                'name' => 'Bunga Papan Pernikahan',
                'deskripsi' => 'Wedding Congratulations Board - Papan bunga untuk ucapan pernikahan',
                'harga' => 1000000,
                'harga_diskon' => 900000,
                'id_kategori' => 1,
                'stok' => 8,
            ],
            [
                'name' => 'Bunga Meja Lily',
                'deskripsi' => 'Table Centerpiece - Arrangement lily elegan untuk meja',
                'harga' => 325000,
                'harga_diskon' => null,
                'id_kategori' => 2,
                'stok' => 12,
            ],
            [
                'name' => 'Buket Bunga Mawar 99',
                'deskripsi' => 'Passionately Yours - 99 tangkai mawar merah premium',
                'harga' => 2650000,
                'harga_diskon' => 2500000,
                'id_kategori' => 1,
                'stok' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->call(AdminUserSeeder::class);
    }
}
