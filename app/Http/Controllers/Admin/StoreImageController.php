<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use App\Models\StoreImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreImageController extends Controller
{
    public function index()
    {
        $images = StoreImage::orderBy('order')->get();
        return view('admin.store_images.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('store', 'public');
                StoreImage::create([
                    'image_path' => $imagePath,
                    'order' => StoreImage::max('order') + 1, // Append to the end
                ]);
            }
        }

        return redirect()->route('admin.store_images.index')->with('success', 'Gambar toko berhasil ditambahkan.');
    }

    public function destroy(StoreImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return redirect()->route('admin.store_images.index')->with('success', 'Gambar toko berhasil dihapus.');
    }
}
