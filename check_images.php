<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Product Images in Database ===\n\n";
$images = DB::table('product_images')
    ->join('products', 'product_images.product_id', '=', 'products.id')
    ->select('product_images.id', 'products.name as product_name', 'product_images.image_path')
    ->get();

foreach ($images as $img) {
    echo "ID: {$img->id} | Product: {$img->product_name}\n";
    echo "Path: {$img->image_path}\n";
    $fullPath = storage_path('app/public/' . $img->image_path);
    echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
    echo "---\n";
}

echo "\n=== Files in storage/app/public/products ===\n\n";
$files = glob(storage_path('app/public/products/*.jpg'));
echo "Total files: " . count($files) . "\n";
foreach (array_slice($files, 0, 5) as $file) {
    echo basename($file) . "\n";
}
