<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Statistik Umum
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('grand_total');

        // Produk Terlaris
        $topSellingProduct = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity_sold')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_quantity_sold')
            ->with('product')
            ->first();

        // Pelanggan Aktif (memiliki setidaknya satu pesanan)
        $activeCustomers = User::has('orders')->count();

        // Data untuk Grafik Penjualan Bulanan (12 bulan terakhir)
        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(grand_total) as total_sales')
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;
            
            $sales = $monthlySales->firstWhere(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });
            $data[] = $sales ? $sales->total_sales : 0;
        }

        return view('admin.reports.index', compact(
            'totalOrders',
            'totalRevenue',
            'topSellingProduct',
            'activeCustomers',
            'labels',
            'data'
        ));
    }

    public function pdf()
    {
        $orders = \App\Models\Order::with('user')->latest()->take(50)->get();
        $pdf = \PDF::loadView('admin.reports.pdf', compact('orders'));
        return $pdf->download('laporan-pesanan.pdf');
    }
}
