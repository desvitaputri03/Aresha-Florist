<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan semua kategori.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'slug' => 'nullable|string',
            'warna' => 'nullable|string',
            'ikon' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // Map description to deskripsi if needed
        $data['deskripsi'] = $data['description'] ?? null;
        unset($data['description']);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Form edit kategori.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'slug' => 'nullable|string',
            'warna' => 'nullable|string',
            'ikon' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // Map description to deskripsi if needed
        $data['deskripsi'] = $data['description'] ?? null;
        unset($data['description']);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
