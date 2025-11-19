<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'harga',
        'harga_diskon',
        'id_kategori',
        'gambar',
        'stok',
    ];

    // relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    // relasi ke cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
