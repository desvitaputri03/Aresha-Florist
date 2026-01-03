<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'harga',
        'harga_diskon',
        'id_kategori',
        // 'gambar', // Hapus ini karena kita akan menggunakan product_images
        'stok',
        'is_combinable',
        'combinable_multiplier',
    ];

    // relasi ke kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    // relasi ke cart
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // relasi ke gambar produk
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }
}
