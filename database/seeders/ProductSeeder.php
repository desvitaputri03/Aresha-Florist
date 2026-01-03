<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->pluck('id')->toArray();

        $products = [
            // Box Bunga
            ['name' => 'Box Bunga Merah Romantis', 'harga' => 250000, 'kategori' => 12, 'stok' => 8, 'deskripsi' => 'Rangkaian bunga merah dalam box mewah untuk momen spesial Anda'],
            ['name' => 'Box Bunga Pink Premium', 'harga' => 300000, 'kategori' => 12, 'stok' => 6, 'deskripsi' => 'Bunga pink premium dengan kombinasi mawar dan carnation'],
            ['name' => 'Box Bunga Putih Elegan', 'harga' => 280000, 'kategori' => 12, 'stok' => 7, 'deskripsi' => 'Rangkaian bunga putih yang elegan dan mewah'],
            ['name' => 'Box Bunga Multicolor', 'harga' => 350000, 'kategori' => 12, 'stok' => 5, 'deskripsi' => 'Kombinasi bunga warna-warni dalam satu box cantik'],
            ['name' => 'Box Bunga Sunflower', 'harga' => 200000, 'kategori' => 12, 'stok' => 10, 'deskripsi' => 'Box berisi bunga matahari cerah dan penuh makna'],
            ['name' => 'Box Bunga Peony Mewah', 'harga' => 400000, 'kategori' => 12, 'stok' => 4, 'deskripsi' => 'Peony premium import dalam box eksklusif'],

            // Papan Rustic
            ['name' => 'Papan Rustic Duka Cita', 'harga' => 180000, 'kategori' => 10, 'stok' => 8, 'deskripsi' => 'Papan bunga rustic untuk menyampaikan belasungkawa'],
            ['name' => 'Papan Rustic Selamat Pernikahan', 'harga' => 220000, 'kategori' => 10, 'stok' => 6, 'deskripsi' => 'Papan rustic khusus untuk merayakan hari pernikahan'],
            ['name' => 'Papan Rustic Ucapan Turut Berduka', 'harga' => 200000, 'kategori' => 10, 'stok' => 7, 'deskripsi' => 'Papan bertuliskan ucapan turut berduka dalam warna lembut'],
            ['name' => 'Papan Rustic Selamat Ulang Tahun', 'harga' => 150000, 'kategori' => 10, 'stok' => 10, 'deskripsi' => 'Papan rustic untuk merayakan hari istimewa'],

            // Papan Akrilik
            ['name' => 'Papan Akrilik Hitam Elegan', 'harga' => 180000, 'kategori' => 11, 'stok' => 12, 'deskripsi' => 'Papan akrilik hitam dengan desain modern dan elegan'],
            ['name' => 'Papan Akrilik Putih Minimalis', 'harga' => 160000, 'kategori' => 11, 'stok' => 14, 'deskripsi' => 'Papan akrilik putih dengan desain minimalis'],
            ['name' => 'Papan Akrilik Gold Mewah', 'harga' => 200000, 'kategori' => 11, 'stok' => 8, 'deskripsi' => 'Papan akrilik dengan aksen gold untuk kesan mewah'],
            ['name' => 'Papan Akrilik Transparan', 'harga' => 140000, 'kategori' => 11, 'stok' => 16, 'deskripsi' => 'Papan akrilik transparan dengan desain unik dan modern'],

            // Rangkaian Bunga
            ['name' => 'Rangkaian Bunga Teratai', 'harga' => 175000, 'kategori' => 12, 'stok' => 5, 'deskripsi' => 'Rangkaian cantik dengan sentuhan teratai asli'],
            ['name' => 'Rangkaian Bunga Tulip Musiman', 'harga' => 225000, 'kategori' => 12, 'stok' => 4, 'deskripsi' => 'Tulip premium dari import musiman'],
            ['name' => 'Rangkaian Bunga Untuk Lamaran', 'harga' => 450000, 'kategori' => 12, 'stok' => 3, 'deskripsi' => 'Rangkaian khusus untuk acara lamaran yang eksklusif'],
            ['name' => 'Rangkaian Bunga Putih Murni', 'harga' => 300000, 'kategori' => 12, 'stok' => 6, 'deskripsi' => 'Bunga putih yang melambangkan kesucian dan ketulusan'],

            // Vase & Standing
            ['name' => 'Vas Bunga Kristal Premium', 'harga' => 350000, 'kategori' => 12, 'stok' => 5, 'deskripsi' => 'Vas kristal premium dengan rangkaian bunga segar'],
            ['name' => 'Standing Bunga Doble Tinggi', 'harga' => 500000, 'kategori' => 10, 'stok' => 2, 'deskripsi' => 'Standing dengan dua tingkat penuh dengan bunga pilihan'],
            ['name' => 'Vas Modern Geometric', 'harga' => 280000, 'kategori' => 12, 'stok' => 7, 'deskripsi' => 'Vas dengan desain geometric modern dan minimalis'],
            ['name' => 'Standing Monochrome Elegan', 'harga' => 450000, 'kategori' => 10, 'stok' => 3, 'deskripsi' => 'Standing dengan warna monochrome yang sangat elegan'],

            // Buket & Hand Bouquet
            ['name' => 'Hand Bouquet Mawar Merah', 'harga' => 200000, 'kategori' => 12, 'stok' => 8, 'deskripsi' => 'Buket tangan dengan mawar merah premium'],
            ['name' => 'Hand Bouquet Lily Putih', 'harga' => 220000, 'kategori' => 12, 'stok' => 6, 'deskripsi' => 'Buket lily putih yang harum dan memukau'],
            ['name' => 'Buket Bunga Matahari Giant', 'harga' => 250000, 'kategori' => 12, 'stok' => 4, 'deskripsi' => 'Buket besar berisi bunga matahari raksasa'],
            ['name' => 'Hand Bouquet Lisianthus Soft', 'harga' => 180000, 'kategori' => 12, 'stok' => 9, 'deskripsi' => 'Buket lisianthus dengan warna pastel yang lembut'],
        ];

        foreach ($products as $product) {
            $categoryId = $product['kategori'];
            
            // Cek apakah kategori valid
            if (!in_array($categoryId, $categories)) {
                $categoryId = Category::first()->id ?? 1;
            }

            Product::updateOrCreate(
                ['name' => $product['name']],
                [
                    'harga' => $product['harga'],
                    'id_kategori' => $categoryId,
                    'stok' => $product['stok'],
                    'deskripsi' => $product['deskripsi'],
                    'is_combinable' => false,
                ]
            );
        }
    }
}
