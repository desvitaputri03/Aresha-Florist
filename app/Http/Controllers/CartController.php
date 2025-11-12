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
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stok
        ]);

        $quantity = $request->input('quantity');
        $userId = Auth::id();
        $sessionId = session()->getId();

        // Cek apakah item sudah ada di keranjang
        $existingCart = Cart::where('product_id', $product->id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existingCart) {
            // Update quantity jika sudah ada
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
        
        return view('cart.checkout', compact('cartItems', 'total'));
    }

    /**
     * Proses checkout
     */
    public function processCheckout(Request $request)
    {
        Log::info('Memulai proses checkout.');
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:100',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string',
                'catatan' => 'nullable|string',
                'payment_method' => 'required|in:cash,transfer',
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
            // Create order
            Log::info('Mencoba membuat pesanan baru.');
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'admin_id' => $admin->id,
                'customer_name' => $request->nama,
                'customer_email' => $request->email,
                'customer_phone' => $request->telepon,
                'customer_address' => $request->alamat,
                'notes' => $request->catatan,
                'payment_method' => $request->payment_method,
                'payment_status' => ($request->payment_method === 'transfer') ? 'pending_transfer' : 'pending',
                'order_status' => ($request->payment_method === 'transfer') ? 'pending_payment' : 'pending',
                'total_amount' => $this->calculateTotal($cartItems),
                'shipping_cost' => 0, // Free shipping
                'grand_total' => $this->calculateTotal($cartItems),
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
                $successMessage .= 'Mohon segera lakukan pembayaran via transfer bank ke rekening BCA 1234567890 a.n. Aresha Florist sebesar Rp' . number_format($order->grand_total, 0, ',', '.') . '. Setelah transfer, silakan unggah bukti pembayaran Anda.';
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

    public function showPaymentConfirmation(Order $order)
    {
        // Ensure the authenticated user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_method !== 'transfer' || $order->payment_status !== 'pending_transfer') {
            return redirect()->route('customer.orders.show', $order->id)->with('error', 'Konfirmasi pembayaran tidak diperlukan untuk pesanan ini.');
        }

        return view('cart.payment_confirmation', compact('order'));
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