<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'admin_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'notes',
        'payment_method',
        'payment_status',
        'proof_of_transfer_image',
        'order_status',
        'total_amount',
        'shipping_cost',
        'grand_total',
        'delivery_date',
        'recipient_name',
        'event_type',
        'custom_message',
    ];

    // Relasi ke user (customer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scope untuk order berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    // Scope untuk order berdasarkan payment method
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    // Generate order number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();
        $sequence = $lastOrder ? (intval(substr($lastOrder->order_number, -4)) + 1) : 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}