<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'slug' => 'nullable|string',
            'warna' => 'nullable|string',
            'ikon' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($request->name);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'slug' => 'nullable|string',
            'warna' => 'nullable|string',
            'ikon' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($request->name);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Tidak dapat menghapus kategori yang memiliki produk.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

