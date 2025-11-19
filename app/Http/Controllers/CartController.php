<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Tampilkan keranjang belanja
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Tambahkan produk ke keranjang
     */
    public function add(Request $request, Product $product)
    {
        // Prevent admin users from adding to cart
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat menambahkan produk ke keranjang.');
        }

        $rules = [
            'quantity' => 'required|integer|min:1|max:' . $product->stok
        ];

        // Add validation rules for combinable options if the product is combinable
        if ($product->is_combinable) {
            $rules['is_combined_order_input'] = 'boolean';
            $rules['combined_quantity_input'] = 'nullable|integer|min:2|max:3';
            if ($request->input('is_combined_order_input')) {
                $rules['combined_quantity_input'] = 'required|integer|min:2|max:3';
            }
        }

        $request->validate($rules);

        $quantity = $request->input('quantity');
        $isCombinedOrder = $request->input('is_combined_order_input', false);
        $combinedQuantity = $request->input('combined_quantity_input');
        $userId = Auth::id();
        $sessionId = session()->getId();

        // Cek apakah item sudah ada di keranjang dengan opsi gabungan yang sama
        $existingCart = Cart::where('product_id', $product->id)
            ->where('is_combined_order', $isCombinedOrder)
            ->where(function($query) use ($combinedQuantity) {
                if ($combinedQuantity !== null) {
                    $query->where('combined_quantity', $combinedQuantity);
                } else {
                    $query->whereNull('combined_quantity');
                }
            })
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existingCart) {
            // Jika sudah ada, update quantity
            $newQuantity = $existingCart->quantity + $quantity;
            if ($newQuantity > $product->stok) {
                return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stok);
            }
            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            // Buat item baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'session_id' => $sessionId,
                'is_combined_order' => $isCombinedOrder,
                'combined_quantity' => $combinedQuantity,
            ]);
        }

        // Opsional: langsung menuju checkout
        if ($request->filled('redirect') && $request->input('redirect') === 'checkout') {
            return redirect()->route('cart.checkout')->with('success', 'Produk ditambahkan. Silakan selesaikan pesanan.');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity item di keranjang
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->product->stok
        ]);

        $cart->update(['quantity' => $request->input('quantity')]);

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    /**
     * Hapus semua item dari keranjang
     */
    public function clear()
    {
        $this->getCartItems()->each->delete();
        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    /**
     * Halaman checkout
     */
    public function checkout()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $total = $this->calculateTotal($cartItems);

        $customerAddress = Auth::check() ? Auth::user()->customer_address : null; // Asumsi customer_address ada di model User
        $shippingCost = $customerAddress ? $this->calculateShippingCost($customerAddress) : 0;
        
        return view('cart.checkout', compact('cartItems', 'total', 'shippingCost'));
    }

    /**
     * Proses checkout
     */
    public function processCheckout(Request $request)
    {
        // Prevent admin users from checking out
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan checkout.');
        }

        Log::info('Memulai proses checkout.');
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:100',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string',
                'catatan' => 'nullable|string',
                'recipient_name' => 'required|string|max:255',
                'event_type' => 'required|string|max:255',
                'custom_message' => 'required|string|max:500',
                'payment_method' => 'required|in:cash,transfer',
                'delivery_date' => 'required|date|after_or_equal:tomorrow',
                'calculated_distance_km' => 'required_if:alamat_not_padang,true|numeric|min:0', // Validasi untuk jarak yang dihitung dari frontend
            ]);
            Log::info('Validasi checkout berhasil.');
        } catch (ValidationException $e) {
            Log::error('Validasi checkout gagal: ' . $e->getMessage());
            return redirect()->route('cart.checkout')->withErrors($e->errors())->withInput();
        }

        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            Log::warning('Keranjang kosong saat checkout.');
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        Log::info('Keranjang tidak kosong. Jumlah item: ' . $cartItems->count());

        // Get admin user (first admin)
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            Log::error('Admin tidak ditemukan untuk proses checkout.');
            return redirect()->route('cart.index')->with('error', 'Admin tidak ditemukan. Silakan hubungi customer service.');
        }
        Log::info('Admin ditemukan: ' . $admin->id);

        DB::beginTransaction();
        Log::info('Transaksi database dimulai.');
        try {
            $totalAmount = $this->calculateTotal($cartItems);
            
            // Dapatkan jarak yang dihitung dari frontend
            $calculatedDistanceKm = (float) $request->input('calculated_distance_km', 0); // Default ke 0 jika tidak ada

            // Cek apakah alamat tujuan berada di Padang
            $isPadang = stripos($request->alamat, 'Padang') !== false;

            // Hitung ongkir menggunakan jarak yang dihitung, atau 0 jika di Padang
            $shippingCost = $this->calculateShippingCost($calculatedDistanceKm, $isPadang);

            $grandTotal = $totalAmount + $shippingCost;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'admin_id' => $admin->id,
                'customer_name' => $request->nama,
                'customer_email' => $request->email,
                'customer_phone' => $request->telepon,
                'customer_address' => $request->alamat,
                'notes' => $request->catatan,
                'recipient_name' => $request->recipient_name,
                'event_type' => $request->event_type,
                'custom_message' => $request->custom_message,
                'payment_method' => $request->payment_method,
                'payment_status' => ($request->payment_method === 'transfer') ? 'pending_transfer' : 'pending',
                'order_status' => ($request->payment_method === 'transfer') ? 'pending_payment' : 'pending',
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'delivery_date' => $request->delivery_date,
            ]);
            Log::info('Pesanan baru berhasil dibuat dengan ID: ' . $order->id . ' dan Nomor Pesanan: ' . $order->order_number);

            // Create order items
            foreach ($cartItems as $cartItem) {
                $price = $cartItem->product->harga_diskon ?? $cartItem->product->harga;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $price,
                    'total_price' => $price * $cartItem->quantity,
                ]);
                Log::info('Item pesanan dibuat untuk produk ID: ' . $cartItem->product_id . ', Quantity: ' . $cartItem->quantity);

                // Update product stock
                $cartItem->product->decrement('stok', $cartItem->quantity);
                Log::info('Stok produk ID: ' . $cartItem->product_id . ' diperbarui.');
            }

            // Clear cart
            $this->getCartItems()->each->delete();
            Log::info('Keranjang berhasil dikosongkan.');

            DB::commit();
            Log::info('Transaksi database selesai (commit).');

            $successMessage = 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number . '. ';

            if ($order->payment_method === 'transfer') {
                $bankAccountNumber = \App\Models\Setting::getSetting('bank_account_number', '[Nomor Rekening Belum Diatur]');
                $bankName = \App\Models\Setting::getSetting('bank_name', '[Nama Bank Belum Diatur]');
                $successMessage .= 'Mohon segera lakukan pembayaran via transfer bank ke rekening ' . $bankName . ' ' . $bankAccountNumber . ' a.n. Aresha Florist sebesar Rp' . number_format($order->grand_total, 0, ',', '.') . '. Setelah transfer, silakan unggah bukti pembayaran Anda.';
                Log::info('Mengarahkan ke halaman konfirmasi pembayaran untuk pesanan ID: ' . $order->id);
                return redirect()->route('cart.payment.confirm', $order->id)->with('success', $successMessage);
            } else {
                $successMessage .= 'Pesanan Anda akan segera diproses. Pembayaran akan dilakukan saat pengiriman. ';
                Log::info('Mengarahkan ke halaman detail pesanan pelanggan untuk pesanan ID: ' . $order->id);
                return redirect()->route('customer.orders.show', $order->id)->with('success', $successMessage);
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error processing checkout: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Get cart items berdasarkan user atau session
     */
    private function getCartItems()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return Cart::with('product')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
    }

    /**
     * Hitung total harga keranjang
     */
    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function($item) {
            $price = $item->product->harga_diskon ?? $item->product->harga;

            // Apply combined board pricing logic
            if ($item->is_combined_order && $item->combined_quantity && $item->product->is_combinable) {
                // If it's a combined order, apply the multiplier based on combined_quantity
                // For '2 papan = 2x price', it means the base price is multiplied by the combinable_multiplier
                // The item->quantity for a combined order is expected to be 1 from the frontend logic.
                return $price * $item->product->combinable_multiplier; // Use combined_multiplier for the total price of the combined set
            }
            
            return $price * $item->quantity;
        });
    }

    /**
     * Get cart count untuk navbar
     */
    public function getCartCount()
    {
        $cartItems = $this->getCartItems();
        return response()->json(['count' => $cartItems->sum('quantity')]);
    }

    /**
     * Hitung biaya pengiriman
     * Untuk sementara, mengembalikan 0 untuk Padang dan biaya per KM untuk luar Padang.
     * Di masa depan, integrasi dengan API pihak ketiga (misalnya Google Maps API) mungkin diperlukan.
     */
    private function calculateShippingCost(float $distanceKm, bool $isPadang): float
    {
        Log::info('Memulai calculateShippingCost. Jarak: ' . $distanceKm . 'km, IsPadang: ' . ($isPadang ? 'Ya' : 'Tidak'));
        if ($isPadang) {
            Log::info('Alamat terdeteksi di Padang. Ongkir: 0.00');
            return 0.00; // Gratis untuk Padang
        }

        // Untuk luar Padang, ambil biaya per KM dari pengaturan admin.
        $costPerKm = (float) \App\Models\Setting::getSetting('cost_per_km_outside_padang', 2000);
        Log::info('Biaya per KM (luar Padang): ' . $costPerKm);

        $calculatedCost = $distanceKm * $costPerKm;
        Log::info('Ongkir terhitung (luar Padang): ' . $calculatedCost);
        return $calculatedCost;
    }

    public function showPaymentConfirmation(Order $order)
    {
        // Ensure the authenticated user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_method !== 'transfer' || $order->payment_status !== 'pending_transfer') {
            return redirect()->route('customer.orders.show', $order->id)->with('error', 'Konfirmasi pembayaran tidak diperlukan untuk pesanan ini.');
        }

        $bankAccountNumber = \App\Models\Setting::getSetting('bank_account_number', '[Nomor Rekening Belum Diatur]');
        $bankName = \App\Models\Setting::getSetting('bank_name', '[Nama Bank Belum Diatur]');

        return view('cart.payment_confirmation', compact('order', 'bankAccountNumber', 'bankName'));
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        // Ensure the authenticated user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_method !== 'transfer' || $order->payment_status !== 'pending_transfer') {
            return redirect()->route('customer.orders.show', $order->id)->with('error', 'Pesanan tidak dalam status menunggu bukti transfer.');
        }

        $request->validate([
            'proof_of_transfer_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('proof_of_transfer_image')) {
            $imagePath = $request->file('proof_of_transfer_image')->store('payment_proofs', 'public');
            $order->update([
                'proof_of_transfer_image' => $imagePath,
                'payment_status' => 'awaiting_admin_approval',
            ]);

            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Bukti transfer berhasil diunggah. Pesanan Anda akan diverifikasi oleh admin.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer. Silakan coba lagi.');
    }
}