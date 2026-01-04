<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController as Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'admin', 'orderItems.product']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('order_status', $request->input('status'));
        }

        // Filter berdasarkan payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        // Filter berdasarkan payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'total_asc':
                $query->orderBy('grand_total', 'asc');
                break;
            case 'total_desc':
                $query->orderBy('grand_total', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'payment_method' => $request->input('payment_method'),
                'payment_status' => $request->input('payment_status'),
                'sort' => $sort,
            ],
        ]);
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['user', 'admin', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed,pending_transfer,awaiting_admin_approval',
        ]);

        $updateData = [
            'order_status' => $request->order_status,
        ];

        // Only update payment_status if provided
        if ($request->filled('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }

        $order->update($updateData);

        // Check if this is AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui!',
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Hapus pesanan
     */
    public function destroy(Order $order)
    {
        // Restore stock jika pesanan dibatalkan
        if ($order->order_status === 'cancelled') {
            foreach ($order->orderItems as $item) {
                $item->product->increment('stok', $item->quantity);
            }
        }

        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    /**
     * Statistik pesanan
     */
    public function statistics()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'processing_orders' => Order::where('order_status', 'processing')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('grand_total'),
            'pending_payment' => Order::where('payment_status', 'pending')->sum('grand_total'),
            'cash_orders' => Order::where('payment_method', 'cash')->count(),
            'transfer_orders' => Order::where('payment_method', 'transfer')->count(),
        ];

        return response()->json($stats);
    }
}