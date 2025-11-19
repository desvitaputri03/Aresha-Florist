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
        // Prepare data before validation for consistency
        $data = $request->all();

        // Handle harga_diskon: set to null if empty string
        if (empty($data['harga_diskon']) && $data['harga_diskon'] !== 0) {
            $data['harga_diskon'] = null;
        }

        // Handle is_combinable checkbox and combinable_multiplier
        $data['is_combinable'] = $request->has('is_combinable');
        if (!$data['is_combinable']) {
            $data['combinable_multiplier'] = null; // Ensure it's null if not combinable
        }

        // Merge the prepared data back into the request for validation
        $request->merge($data);

        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_diskon' => 'nullable|numeric|min:0',
            'id_kategori' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer|min:0',
            'is_combinable' => 'boolean',
            'combinable_multiplier' => 'required_if:is_combinable,true|integer|min:1',
        ]);

        // Handle image upload after validation
        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            // Prepare data before validation for consistency
            $data = $request->all();

            // Handle harga_diskon: set to null if empty string
            if (empty($data['harga_diskon']) && $data['harga_diskon'] !== 0) {
                $data['harga_diskon'] = null;
            }

            // Handle is_combinable checkbox and combinable_multiplier
            $data['is_combinable'] = $request->has('is_combinable');
            if (!$data['is_combinable']) {
                $data['combinable_multiplier'] = null; // Ensure it's null if not combinable
            }

            // Merge the prepared data back into the request for validation
            $request->merge($data);

            $validatedData = $request->validate([
                'name' => 'required|string|max:150',
                'deskripsi' => 'nullable|string',
                'harga' => 'required|numeric|min:0',
                'harga_diskon' => 'nullable|numeric|min:0',
                'id_kategori' => 'required|exists:categories,id',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'stok' => 'required|integer|min:0',
                'is_combinable' => 'boolean',
                'combinable_multiplier' => 'required_if:is_combinable,true|integer|min:1',
            ]);

            // Set deskripsi to null if it's an empty string
            if (empty($validatedData['deskripsi'])) {
                $validatedData['deskripsi'] = null;
            }

            // Handle image upload after validation
            if ($request->hasFile('gambar')) {
                $validatedData['gambar'] = $request->file('gambar')->store('products', 'public');
            }

            $product->update($validatedData);

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Illuminate\Support\Facades\Log::error('Error updating product: ' . $e->getMessage(), ['exception' => $e]);
            
            // Redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['gagal_update' => 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

