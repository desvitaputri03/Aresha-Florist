<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Get all available images from storage
        $storagePath = storage_path('app/public/products');
        $images = File::files($storagePath);
        
        if (empty($images)) {
            $this->command->warn('No images found in storage/app/public/products');
            return;
        }

        // Get products without images
        $productsWithoutImages = Product::whereDoesntHave('images')->get();

        if ($productsWithoutImages->isEmpty()) {
            $this->command->info('All products already have images');
            return;
        }

        $imageCount = count($images);

        foreach ($productsWithoutImages as $index => $product) {
            // Cycle through available images
            $imageFile = $images[$index % $imageCount];
            $imageName = $imageFile->getFilename();

            ProductImage::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'image_path' => "products/$imageName"
                ],
                [
                    'image_path' => "products/$imageName"
                ]
            );

            $this->command->line("Added image to: {$product->name}");
        }

        $this->command->info('Product images seeded successfully');
    }
}
