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
        
        // DEFAULT: Januari sampai Desember tahun berjalan (2026)
        $startMonth = $request->input('start_month', 1);
        $startYear = $request->input('start_year', $now->year);
        $endMonth = $request->input('end_month', 12);
        $endYear = $request->input('end_year', $now->year);

        $request->merge([
            'start_month' => $startMonth,
            'start_year' => $startYear,
            'end_month' => $endMonth,
            'end_year' => $endYear
        ]);

        $startDate = Carbon::create($startYear, $startMonth, 1)->startOfMonth();
        $endDate = Carbon::create($endYear, $endMonth, 1)->endOfMonth();

        // Statistik Berdasarkan Filter (Hanya Pesanan PAID)
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->count();

        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        // Produk Terlaris (Top 5 untuk Grafik Pie)
        $popularProducts = OrderItem::whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->where('payment_status', 'paid');
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();

        $topSellingProduct = $popularProducts->first();

        // Pelanggan Aktif
        $activeCustomers = User::whereHas('orders', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->where('payment_status', 'paid');
            })->count();

        // Data Grafik Penjualan
        $salesData = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(grand_total) as total_sales')
            )
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->get();

        $labels = [];
        $data = [];
        
        $currentDate = $startDate->copy();
        \Carbon\Carbon::setLocale('id');
        while ($currentDate->lte($endDate)) {
            $labels[] = $currentDate->isoFormat('MMMM YYYY');
            $sales = $salesData->firstWhere(fn($item) => $item->year == $currentDate->year && $item->month == $currentDate->month);
            $data[] = $sales ? (float)$sales->total_sales : 0;
            $currentDate->addMonth();
        }
        \Carbon\Carbon::setLocale('en');

        return view('admin.reports.index', compact(
            'totalOrders', 'totalRevenue', 'topSellingProduct', 'popularProducts',
            'activeCustomers', 'labels', 'data', 'period',
            'startMonth', 'startYear', 'endMonth', 'endYear'
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

        $orders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('grand_total');
        $totalOrders = $orders->count();

        \Carbon\Carbon::setLocale('id');
        $periodeStr = $startDate->isoFormat('MMMM YYYY');
        if ($startDate->format('Y-m') != $endDate->format('Y-m')) {
            $periodeStr .= ' - ' . $endDate->isoFormat('MMMM YYYY');
        }

        $pdf = \PDF::loadView('admin.reports.pdf', compact('orders', 'totalRevenue', 'totalOrders', 'periodeStr'));
        return $pdf->download('laporan-penjualan-' . strtolower(str_replace(' ', '-', $periodeStr)) . '.pdf');
    }
}