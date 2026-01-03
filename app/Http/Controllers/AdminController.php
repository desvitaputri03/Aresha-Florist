<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User; // Tambahkan ini
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

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

    public function backupUsers()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_backup_' . now()->format('Ymd_His') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['id', 'name', 'email', 'is_admin', 'created_at', 'updated_at']);

            User::chunk(2000, function ($users) use ($file) {
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->is_admin ? 1 : 0,
                        $user->created_at,
                        $user->updated_at,
                    ]);
                }
            });
            fclose($file);
        };

        return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, 200, $headers);
    }

    public function restoreUsers(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:csv,txt|max:10240', // Max 10MB
        ]);

        DB::beginTransaction();
        try {
            // Truncate current users table (careful with this in production!)
            User::truncate();

            $file = $request->file('backup_file')->openFile('r');
            $header = fgetcsv($file); // Skip header

            while (($row = fgetcsv($file)) !== FALSE) {
                // Assuming CSV columns are: id, name, email, is_admin, created_at, updated_at
                // We won't restore password directly from CSV for security, new users will need to reset or have default password.
                // For existing users, we'd match by email and update other fields.
                // For simplicity, this restore assumes a fresh table and only populates basic info.

                // You might need to adjust this logic based on how you want to handle existing users and passwords
                User::create([
                    // 'id' => $row[0], // Auto-increment ID might cause issues if not handled carefully
                    'name' => $row[1],
                    'email' => $row[2],
                    // Default password for restored users. They should reset it.
                    'password' => Hash::make('password'), // Atau gunakan password default yang aman
                    'is_admin' => (bool)$row[3],
                    'created_at' => $row[4],
                    'updated_at' => $row[5],
                ]);
            }
            DB::commit();
            return back()->with('success', 'Data pengguna berhasil dipulihkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the exception for debugging
            \Illuminate\Support\Facades\Log::error('Error restoring users: ' . $e->getMessage(), ['exception' => $e]);

            return back()->with('error', 'Terjadi kesalahan saat memulihkan data pengguna: ' . $e->getMessage());
        }
    }
}

