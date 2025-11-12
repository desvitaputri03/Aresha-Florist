<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('id_kategori', $product->id_kategori)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Product::with('category');

        // Search by keyword
        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by category id
        if ($request->filled('category')) {
            $query->where('id_kategori', $request->input('category'));
        }

        // Price range using effective price (harga_diskon if set, else harga)
        $priceFrom = $request->input('price_from');
        $priceTo = $request->input('price_to');
        if ($priceFrom !== null || $priceTo !== null) {
            $from = is_numeric($priceFrom) ? (int) $priceFrom : 0;
            $to = is_numeric($priceTo) ? (int) $priceTo : PHP_INT_MAX;
            $query->where(function ($q) use ($from, $to) {
                $q->where(function ($q1) use ($from, $to) {
                    $q1->whereNotNull('harga_diskon')
                        ->whereBetween('harga_diskon', [$from, $to]);
                })->orWhere(function ($q2) use ($from, $to) {
                    $q2->whereNull('harga_diskon')
                        ->whereBetween('harga', [$from, $to]);
                });
            });
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        switch ($sort) {
            case 'price_low_high':
                // Order by effective price asc
                $query->orderByRaw('COALESCE(harga_diskon, harga) asc');
                break;
            case 'price_high_low':
                $query->orderByRaw('COALESCE(harga_diskon, harga) desc');
                break;
            case 'name_asc':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_produk', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'newest':
                $query->latest();
                break;
            case 'featured':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'q' => $request->input('q'),
                'category' => $request->input('category'),
                'price_from' => $request->input('price_from'),
                'price_to' => $request->input('price_to'),
                'sort' => $sort,
            ],
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'harga_diskon' => 'nullable|numeric',
            'id_kategori' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer',
        ]);

        $data = $request->all();

        // handle upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'harga_diskon' => 'nullable|numeric',
            'id_kategori' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
