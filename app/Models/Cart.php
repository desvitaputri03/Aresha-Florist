<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'session_id',
        'is_combined_order',
        'combined_quantity',
        'combined_with_product_id',
        'combined_custom_request',
    ];

    // Relasi ke user (jika login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke produk yang digabung
    public function combinedWithProduct()
    {
        return $this->belongsTo(Product::class, 'combined_with_product_id');
    }

    // Scope untuk cart berdasarkan session atau user
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Hitung total harga item ini
    public function getTotalPriceAttribute()
    {
        $price = $this->product->harga_diskon ?? $this->product->harga;
        return $price * $this->quantity;
    }
}

