<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru untuk ditampilkan di beranda
        $featuredProducts = Product::with('category')
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
}

