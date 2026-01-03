<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'monthly'); // Default to monthly
        $startMonth = $request->input('start_month');
        $startYear = $request->input('start_year');
        $endMonth = $request->input('end_month');
        $endYear = $request->input('end_year');

        // Menggunakan Carbon untuk tanggal
        $now = now();

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

        // Data untuk Grafik Penjualan
        $salesQuery = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as period_unit'), // Selalu gunakan bulanan
                DB::raw('SUM(grand_total) as total_sales')
            )
            ->where('payment_status', 'paid')
            ->groupBy('year', 'period_unit')
            ->orderBy('year')
            ->orderBy('period_unit');

        $startDate = null;
        $endDate = null;

        if ($startMonth && $startYear) {
            $startDate = Carbon::create($startYear, $startMonth, 1)->startOfMonth();
            $salesQuery->where('created_at', '>=', $startDate);
        }

        if ($endMonth && $endYear) {
            $endDate = Carbon::create($endYear, $endMonth, 1)->endOfMonth();
            $salesQuery->where('created_at', '<=', $endDate);
        }

        // Default jika tidak ada filter tanggal yang disediakan
        if (!$startDate && !$endDate) {
        // Default jika tidak ada filter tanggal yang disediakan, selalu gunakan bulanan
        $salesQuery->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth());
        }

        $salesData = $salesQuery->get();

        $labels = [];
        $data = [];
        
        if ($period == 'monthly') {
            $currentDate = $startDate ?? $now->copy()->subMonths(11)->startOfMonth();
            $finalDate = $endDate ?? $now->copy()->endOfMonth();

            \Carbon\Carbon::setLocale('id'); // Atur locale ke Bahasa Indonesia
            while ($currentDate->lte($finalDate)) {
                $date = $currentDate->copy();
                
                // Gunakan format bahasa Indonesia untuk bulan
                $monthYear = $date->isoFormat('MMMM YYYY'); // Menggunakan isoFormat sebagai pengganti formatLocalized
                $labels[] = $monthYear;
                
                $sales = $salesData->firstWhere(function ($item) use ($date) {
                    return $item->year == $date->year && $item->period_unit == $date->month;
                });
                $data[] = $sales ? $sales->total_sales : 0;
                $currentDate->addMonth();
            }
            \Carbon\Carbon::setLocale('en'); // Reset locale ke default setelah selesai
        }

        return view('admin.reports.index', compact(
            'totalOrders',
            'totalRevenue',
            'topSellingProduct',
            'activeCustomers',
            'labels',
            'data',
            'period'
        ));
    }

    public function pdf()
    {
        $orders = \App\Models\Order::with('user')->latest()->take(50)->get();
        $pdf = \PDF::loadView('admin.reports.pdf', compact('orders'));
        return $pdf->download('laporan-pesanan.pdf');
    }

    public function stockReport(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('id_kategori', $request->input('category_id'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $products = $query->orderBy('name')->get();

        return view('admin.reports.stock', compact('products', 'categories', 'request'));
    }

    public function popularProductsReport(Request $request)
    {
        $query = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity_sold')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_quantity_sold');

        if ($request->filled('start_date')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->input('start_date'));
            });
        }

        if ($request->filled('end_date')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->input('end_date'));
            });
        }

        $popularProducts = $query->with('product')->get();

        return view('admin.reports.popular_products', compact('popularProducts', 'request'));
    }
}
