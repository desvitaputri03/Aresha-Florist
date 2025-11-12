<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Data laporan bisa diisi sesuai kebutuhan
        return view('admin.reports.index');
    }

    public function pdf()
    {
        $orders = \App\Models\Order::with('user')->latest()->take(50)->get();
        $pdf = \PDF::loadView('admin.reports.pdf', compact('orders'));
        return $pdf->download('laporan-pesanan.pdf');
    }
}
