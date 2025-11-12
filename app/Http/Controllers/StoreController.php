<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Halaman utama toko
    public function index()
    {
        $categories = Category::all();
        $products = Product::latest()->get();
        return view('store.index', compact('categories', 'products'));
    }

    // Detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('store.show', compact('product'));
    }
}
