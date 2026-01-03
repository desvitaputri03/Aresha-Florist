<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Database\Seeders\GeoDataSeeder; // Tambahkan ini
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder data geografis terlebih dahulu
        $this->call(GeoDataSeeder::class);

        // Create categories
        $categories = [
            ['name' => 'Bunga Papan Wedding', 'deskripsi' => 'Karangan bunga papan untuk ucapan pernikahan'],
            ['name' => 'Bunga Papan Duka Cita', 'deskripsi' => 'Karangan bunga papan untuk ucapan duka cita'],
            ['name' => 'Bunga Papan Congratulations', 'deskripsi' => 'Karangan bunga papan untuk ucapan selamat dan sukses'],
            ['name' => 'Papan Rustic', 'deskripsi' => 'Karangan bunga dengan gaya rustic yang elegan'],
            ['name' => 'Bunga Akrilik', 'deskripsi' => 'Karangan bunga mini dengan media akrilik'],
            ['name' => 'Bunga Box', 'deskripsi' => 'Rangkaian bunga cantik dalam kotak premium'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Karangan Bunga Papan Wedding Premium',
                'deskripsi' => 'Karangan bunga papan ukuran besar dengan desain elegan untuk hari bahagia pelanggan.',
                'harga' => 1200000,
                'harga_diskon' => 845000,
                'id_kategori' => 1,
                'stok' => 25,
            ],
            [
                'name' => 'Papan Bunga Duka Cita Simpati',
                'deskripsi' => 'Karangan bunga papan untuk menyampaikan rasa duka cita yang mendalam.',
                'harga' => 750000,
                'harga_diskon' => 650000,
                'id_kategori' => 2,
                'stok' => 18,
            ],
            [
                'name' => 'Papan Rustic Elegant Type A',
                'deskripsi' => 'Rangkaian bunga papan gaya rustic dengan sentuhan kayu dan bunga pilihan.',
                'harga' => 550000,
                'harga_diskon' => null,
                'id_kategori' => 4,
                'stok' => 30,
            ],
            [
                'name' => 'Bunga Box Exclusive Pink',
                'deskripsi' => 'Rangkaian bunga dalam box premium untuk hadiah spesial.',
                'harga' => 425000,
                'harga_diskon' => null,
                'id_kategori' => 6,
                'stok' => 15,
            ],
            [
                'name' => 'Bunga Akrilik Ucapan Meja',
                'deskripsi' => 'Akrilik bunga cantik untuk hiasan meja atau ucapan simpel.',
                'harga' => 375000,
                'harga_diskon' => null,
                'id_kategori' => 5,
                'stok' => 22,
            ],
            [
                'name' => 'Karangan Bunga Papan Congratulations XL',
                'deskripsi' => 'Papan bunga ukuran ekstra besar untuk peresmian atau pembukaan toko.',
                'harga' => 2000000,
                'harga_diskon' => 1800000,
                'id_kategori' => 3,
                'stok' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->call(AdminUserSeeder::class);
    }
}
