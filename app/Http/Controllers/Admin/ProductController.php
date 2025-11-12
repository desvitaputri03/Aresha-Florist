<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('id_kategori', $request->input('category'));
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            $status = $request->input('stock_status');
            switch ($status) {
                case 'in_stock':
                    $query->where('stok', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stok', '>', 0)->where('stok', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stok', 0);
                    break;
            }
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderByRaw('COALESCE(harga_diskon, harga) asc');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(harga_diskon, harga) desc');
                break;
            case 'stock_asc':
                $query->orderBy('stok', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stok', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(15)->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'stock_status' => $request->input('stock_status'),
                'sort' => $sort,
            ],
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric|min:0',
            'id_kategori' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric|min:0',
            'id_kategori' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

