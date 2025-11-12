<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class AdminController extends BaseAdminController
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        // Handle cases where the orders table may not exist yet
        $totalOrders = 0;
        $totalRevenue = 0;
        if (Schema::hasTable('orders')) {
            $totalOrders = Order::whereDate('created_at', today())->count();
            $totalRevenue = Order::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('grand_total');
        }
        
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();
            
        $lowStockProducts = Product::where('stok', '>', 0)
            ->where('stok', '<=', 10)
            ->count();
            
        $outOfStockProducts = Product::where('stok', 0)->count();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories', 
            'totalOrders',
            'totalRevenue',
            'recentProducts',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }
}

