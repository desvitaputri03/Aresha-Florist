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
        $period = $request->input('period', 'monthly');
        
        $now = now();
        $defaultStart = $now->copy()->subMonths(11);
        
        $startMonth = $request->input('start_month', $defaultStart->month);
        $startYear = $request->input('start_year', $defaultStart->year);
        $endMonth = $request->input('end_month', $now->month);
        $endYear = $request->input('end_year', $now->year);

        // Pastikan variabel dilempar balik ke view untuk seleksi filter
        $request->merge([
            'start_month' => $startMonth,
            'start_year' => $startYear,
            'end_month' => $endMonth,
            'end_year' => $endYear
        ]);

        $startDate = Carbon::create($startYear, $startMonth, 1)->startOfMonth();
        $endDate = Carbon::create($endYear, $endMonth, 1)->endOfMonth();

        // Statistik Berdasarkan Filter (Hanya Pesanan yang SUDAH DIBAYAR/PAID)
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->count();

        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        // Produk Terlaris Berdasarkan Filter (Hanya dari pesanan paid)
        $topSellingProduct = OrderItem::whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->where('payment_status', 'paid');
            })
            ->select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity_sold')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_quantity_sold')
            ->with('product')
            ->first();

        // Pelanggan Aktif Berdasarkan Filter (Hanya yang memiliki pesanan paid)
        $activeCustomers = User::whereHas('orders', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->where('payment_status', 'paid');
            })->count();

        // Data untuk Grafik Penjualan (Tetap tampilkan 12 bulan terakhir jika filter tidak disetel manual? 
        // Tidak, sebaiknya ikuti filter agar grafik sinkron dengan tabel statistik di bawahnya)
        
        $salesQuery = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as period_unit'),
                DB::raw('SUM(grand_total) as total_sales')
            )
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'period_unit')
            ->orderBy('year')
            ->orderBy('period_unit');

        $salesData = $salesQuery->get();

        $labels = [];
        $data = [];
        
        if ($period == 'monthly') {
            $currentDate = $startDate->copy();
            $finalDate = $endDate->copy();

            \Carbon\Carbon::setLocale('id');
            while ($currentDate->lte($finalDate)) {
                $date = $currentDate->copy();
                $monthYear = $date->isoFormat('MMMM YYYY');
                $labels[] = $monthYear;
                
                $sales = $salesData->firstWhere(function ($item) use ($date) {
                    return $item->year == $date->year && $item->period_unit == $date->month;
                });
                $data[] = $sales ? $sales->total_sales : 0;
                $currentDate->addMonth();
            }
            \Carbon\Carbon::setLocale('en');
        }

        return view('admin.reports.index', compact(
            'totalOrders',
            'totalRevenue',
            'topSellingProduct',
            'activeCustomers',
            'labels',
            'data',
            'period',
            'startMonth',
            'startYear',
            'endMonth',
            'endYear'
        ));
    }

    public function pdf(Request $request)
    {
        $startMonth = $request->input('start_month', now()->month);
        $startYear = $request->input('start_year', now()->year);
        $endMonth = $request->input('end_month', now()->month);
        $endYear = $request->input('end_year', now()->year);

        $startDate = Carbon::create($startYear, $startMonth, 1)->startOfMonth();
        $endDate = Carbon::create($endYear, $endMonth, 1)->endOfMonth();

        // Ambil pesanan yang SUDAH DIBAYAR saja agar totalnya sinkron dengan dashboard
        $orders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('grand_total');
        $totalOrders = $orders->count();

        // Penamaan bulan untuk judul laporan
        \Carbon\Carbon::setLocale('id');
        $periodeStr = $startDate->isoFormat('MMMM YYYY');
        if ($startDate->format('Y-m') != $endDate->format('Y-m')) {
            $periodeStr .= ' - ' . $endDate->isoFormat('MMMM YYYY');
        }

        $pdf = \PDF::loadView('admin.reports.pdf', compact('orders', 'totalRevenue', 'totalOrders', 'periodeStr'));
        return $pdf->download('laporan-penjualan-' . strtolower(str_replace(' ', '-', $periodeStr)) . '.pdf');
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
