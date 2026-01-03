<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StoreSetting;
use App\Models\StoreImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru untuk ditampilkan di beranda
        $featuredProducts = Product::with('category', 'images') // Tambahkan 'images' ke eager loading
            ->where('stok', '>', 0) // Hanya produk yang ada stoknya
            ->latest()
            ->limit(6)
            ->get();

        // Ambil semua kategori untuk navigasi
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('welcome', compact('featuredProducts', 'categories'));
    }

    public function storeInfo()
    {
        $storeSettings = StoreSetting::first(); // Asumsi hanya ada satu baris untuk pengaturan toko
        $storeImages = StoreImage::orderBy('order')->get();
        return view('store-info', compact('storeSettings', 'storeImages'));
    }
}

