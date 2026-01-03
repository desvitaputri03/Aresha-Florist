<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportAllProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        // Get all existing image filenames from database
        $existingImages = DB::table('product_images')
            ->pluck('image_path')
            ->map(fn($path) => basename($path))
            ->toArray();

        // Get all image files from storage
        $allFiles = glob(storage_path('app/public/products/*.jpg'));
        
        // Categories mapping (cycling through existing categories)
        $categories = DB::table('categories')->pluck('id')->toArray();
        
        $productNames = [
            'Papan Bunga Ucapan',
            'Rangkaian Bunga Premium',
            'Papan Bunga Wisuda',
            'Box Bunga Spesial',
            'Papan Bunga Dukacita',
            'Papan Bunga Pernikahan',
            'Standing Flower',
            'Hand Bouquet',
            'Bunga Meja',
            'Papan Bunga Congratulations',
        ];

        $counter = 0;
        
        foreach ($allFiles as $filePath) {
            $filename = basename($filePath);
            $relativePath = 'products/' . $filename;
            
            // Skip if already in database
            if (in_array($filename, $existingImages)) {
                continue;
            }

            // Create product
            $productId = DB::table('products')->insertGetId([
                'name' => $productNames[$counter % count($productNames)] . ' ' . ($counter + 1),
                'deskripsi' => 'Rangkaian bunga segar dengan kualitas premium untuk berbagai acara.',
                'harga' => rand(100, 250) * 1000,
                'harga_diskon' => null,
                'id_kategori' => $categories[$counter % count($categories)],
                'gambar' => null,
                'stok' => rand(10, 50),
                'is_combinable' => 0,
                'combinable_multiplier' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create product image
            DB::table('product_images')->insert([
                'product_id' => $productId,
                'image_path' => $relativePath,
                'order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $counter++;
            echo "✓ Created product: " . $productNames[$counter % count($productNames)] . " $counter\n";
        }

        echo "\n✅ Total products created: $counter\n";
        echo "✅ Total products with images: " . DB::table('product_images')->count() . "\n";
    }
}
