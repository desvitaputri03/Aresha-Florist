<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'slug',
        'warna',
        'ikon',
        'is_active',
    ];

    // Relasi ke produk
    public function products()
    {
        return $this->hasMany(Product::class, 'id_kategori');
    }
}
