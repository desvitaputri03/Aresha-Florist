<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\District; // Tambahkan ini
use App\Models\Province; // Tambahkan ini
use App\Models\Regency; // Tambahkan ini
use App\Models\Setting; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http; // Tambahkan ini
use Illuminate\Support\Facades\Mail; // Tambahkan ini
use App\Mail\NewOrderNotification; // Tambahkan ini
use App\Mail\CustomerOrderConfirmation; // Tambahkan ini
use App\Services\WhatsAppService; // Tambahkan ini
use Illuminate\Support\Facades\Queue;

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
        Log::info('CartController@add: Menerima request', $request->all());

        $rules = [
            'quantity' => 'required|integer|min:1|max:' . $product->stok
        ];

        // Add validation rules for combinable options if the product is combinable
        if ($product->is_combinable) {
            $rules['is_combined_order_input'] = 'boolean';
            $rules['combined_quantity_input'] = 'nullable';
            $rules['combined_custom_request_input'] = 'nullable|string|max:500';
            if ($request->input('is_combined_order_input')) {
                // Either combined_quantity (2 or 3) OR custom_request must be provided
                if (empty($request->input('combined_quantity_input')) && empty($request->input('combined_custom_request_input'))) {
                    $rules['combined_quantity_input'] = 'required_without:combined_custom_request_input';
                    $rules['combined_custom_request_input'] = 'required_without:combined_quantity_input';
                }
            }
        }

        $request->validate($rules);

        $quantity = $request->input('quantity');
        $isCombinedOrder = $request->input('is_combined_order_input', false);
        $combinedQuantity = $request->input('combined_quantity_input');
        $combinedCustomRequest = $request->input('combined_custom_request_input');

        $userId = Auth::id();
        $sessionId = session()->getId();

        // Cek apakah item sudah ada di keranjang dengan opsi gabungan yang sama
        $existingCart = Cart::where('product_id', $product->id)
            ->where('is_combined_order', $isCombinedOrder)
            ->where(function ($query) use ($combinedQuantity) {
                if ($combinedQuantity !== null && $combinedQuantity !== '') {
                    $query->where('combined_quantity', $combinedQuantity);
                } else {
                    $query->whereNull('combined_quantity');
                }
            })
            ->where(function ($query) use ($combinedCustomRequest) {
                if ($combinedCustomRequest !== null && $combinedCustomRequest !== '') {
                    $query->where('combined_custom_request', $combinedCustomRequest);
                } else {
                    $query->whereNull('combined_custom_request');
                }
            })
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existingCart) {
            // Jika sudah ada, update quantity (SET quantity agar sinkron dengan input pelanggan)
            $newQuantity = $quantity;
            if ($newQuantity > $product->stok) {
                return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stok);
            }
            $existingCart->update(['quantity' => $newQuantity]);
            Log::info('CartController@add: Item keranjang diupdate', ['cart_id' => $existingCart->id, 'updated_quantity' => $newQuantity]);
        } else {
            // Buat item baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'session_id' => $sessionId,
                'is_combined_order' => $isCombinedOrder,
                'combined_quantity' => $combinedQuantity ?: null,
                'combined_custom_request' => $combinedCustomRequest ?: null,
            ]);
        }

        // Opsional: langsung menuju checkout
        if ($request->filled('redirect') && $request->input('redirect') === 'checkout') {
            Log::info('CartController@add: Redirect ke checkout.');
            return redirect()->route('cart.checkout')->with('success', 'Produk ditambahkan. Silakan selesaikan pesanan.');
        }

        Log::info('CartController@add: Kembali ke halaman sebelumnya.');
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

        // Default values for Padang only (free shipping)
        $shippingCost = 0;
        $isPadang = true;

        // Get ID for 'Sumatera Barat' province and 'Kota Padang' regency
        $sumateraBarat = Province::where('name', 'Sumatera Barat')->first();
        $kotaPadang = Regency::where('name', 'Kota Padang')->first();

        $provinces = Province::all(['id', 'name']);
        $regencies = $sumateraBarat ? $sumateraBarat->regencies()->get(['id', 'name']) : collect();
        $districts = $kotaPadang ? $kotaPadang->districts()->get(['id', 'name', 'postal_code']) : collect();

        return view('cart.checkout', compact('cartItems', 'total', 'shippingCost', 'isPadang', 'provinces', 'regencies', 'districts', 'sumateraBarat', 'kotaPadang'));
    }

    /**
     * Proses checkout
     */
    public function processCheckout(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string',
                'catatan' => 'nullable|string',
                'recipient_name' => 'required|string|max:255',
                'event_type' => 'required|string|max:255',
                'custom_message' => 'required|string|max:500',
                'payment_method' => 'required|in:cash,transfer,cod,payment_gateway',
                'delivery_date' => 'required|date|after_or_equal:today',
            ]);
        } catch (ValidationException $e) {
            return redirect()->route('cart.checkout')->withErrors($e->errors())->withInput();
        }

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // Get admin user (first admin)
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            return redirect()->route('cart.index')->with('error', 'Admin tidak ditemukan. Silakan hubungi customer service.');
        }

        DB::beginTransaction();
        try {
            $totalAmount = $this->calculateTotal($cartItems);

            // Karena hanya pengiriman di Padang, ongkir selalu 0
            $shippingCost = 0;
            $grandTotal = $totalAmount + $shippingCost;

            $customerFullAddress = $request->alamat;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'admin_id' => $admin->id,
                'customer_name' => $request->nama,
                'customer_email' => $request->email,
                'customer_phone' => $request->telepon,
                'customer_address' => $customerFullAddress, // Gunakan alamat lengkap yang dibangun
                'notes' => $request->catatan,
                'recipient_name' => $request->recipient_name,
                'event_type' => $request->event_type,
                'custom_message' => $request->custom_message,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'transfer' ? 'pending_transfer' :
                    ($request->payment_method === 'cod' ? 'pending_cod' :
                        ($request->payment_method === 'cash' ? 'pending' :
                            ($request->payment_method === 'payment_gateway' ? 'pending_payment_gateway' : 'pending'))),
                'order_status' => $request->payment_method === 'transfer' ? 'pending_payment' :
                    ($request->payment_method === 'cod' ? 'pending_cod_verification' :
                        ($request->payment_method === 'cash' ? 'pending' :
                            ($request->payment_method === 'payment_gateway' ? 'pending_payment_gateway' : 'pending'))),
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'delivery_date' => $request->delivery_date,
            ]);

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

                // Update product stock
                $cartItem->product->decrement('stok', $cartItem->quantity);
            }

            // Clear cart
            $this->getCartItems()->each->delete();

            DB::commit();

            // Simpan order ID untuk digunakan di background job
            $orderId = $order->id;
            $adminId = $admin->id;
            $customerPhone = $request->telepon;

            // Kirim notifikasi email dan WhatsApp di background (tidak blocking)
            // Menggunakan dispatchAfterResponse agar tidak memperlambat response ke user
            dispatch(function () use ($orderId, $adminId, $customerPhone) {
                // Reload order dan admin untuk memastikan data terbaru
                $order = \App\Models\Order::find($orderId);
                $admin = \App\Models\User::find($adminId);

                if (!$order) {
                    return;
                }

                // Kirim notifikasi email ke admin untuk pesanan baru
                try {
                    if ($admin && $admin->email) {
                        Mail::to($admin->email)->send(new NewOrderNotification($order));
                    }
                } catch (\Exception $mailError) {
                    Log::error('Gagal mengirim email notifikasi pesanan baru ke admin: ' . $mailError->getMessage());
                }

                // Kirim notifikasi email ke pelanggan
                try {
                    if ($order->customer_email) {
                        Mail::to($order->customer_email)->send(new CustomerOrderConfirmation($order));
                    }
                } catch (\Exception $mailError) {
                    Log::error('Gagal mengirim email konfirmasi pesanan ke pelanggan: ' . $mailError->getMessage());
                }

                // Kirim notifikasi WhatsApp ke admin dan pelanggan
                try {
                    $whatsAppService = new WhatsAppService();
                    // Dapatkan nomor telepon admin dari pengaturan atau default
                    $adminPhoneNumber = Setting::getSetting('whatsapp_admin_phone_number', '+6281234567890');
                    if ($adminPhoneNumber) {
                        $whatsAppService->sendNewOrderNotification($order, $adminPhoneNumber);
                    }
                    // Nomor telepon pelanggan dari request
                    if ($customerPhone) {
                        $whatsAppService->sendOrderConfirmation($order, $customerPhone);
                    }
                } catch (\Exception $whatsappError) {
                    Log::error('Gagal mengirim notifikasi WhatsApp: ' . $whatsappError->getMessage());
                }
            })->afterResponse();

            $successMessage = 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number . '. ';

            if ($order->payment_method === 'transfer') {
                $bankAccountNumber = \App\Models\Setting::getSetting('bank_account_number', '[Nomor Rekening Belum Diatur]');
                $bankName = \App\Models\Setting::getSetting('bank_name', '[Nama Bank Belum Diatur]');
                $successMessage .= 'Mohon segera lakukan pembayaran via transfer bank ke rekening ' . $bankName . ' ' . $bankAccountNumber . ' a.n. Aresha Florist sebesar Rp' . number_format($order->grand_total, 0, ',', '.') . '. Setelah transfer, silakan unggah bukti pembayaran Anda.';
                return redirect()->route('cart.payment.confirm', $order->id)->with('success', $successMessage);
            } else if ($order->payment_method === 'payment_gateway') {
                // --- Placeholder untuk Inisialisasi Payment Gateway --- //
                // Di sini Anda akan mengintegrasikan dengan SDK payment gateway yang sebenarnya.
                // Contoh: Inisialisasi transaksi, dapatkan URL redirect.

                // Untuk tujuan demo, kita akan mensimulasikan URL redirect.
                $paymentGatewayRedirectUrl = route('cart.success', $order->id) . '?status=pending_payment_gateway';

                // Anda mungkin juga perlu menyimpan payment_gateway_order_id yang sebenarnya dari respons payment gateway
                $order->update([
                    'payment_gateway_order_id' => 'PG-' . $order->order_number, // ID dari payment gateway
                    'payment_gateway_status' => 'pending', // Status awal dari payment gateway
                ]);

                return redirect()->away($paymentGatewayRedirectUrl);
            } else if ($order->payment_method === 'cod') {
                $successMessage .= 'Pesanan Anda akan segera diproses. Pembayaran akan dilakukan saat pengiriman (COD). ';
                return redirect()->route('cart.success', $order->id)->with('success', $successMessage);
            } else if ($order->payment_method === 'cash') {
                $successMessage .= 'Pesanan Anda akan segera diproses. Silakan ambil dan bayar langsung di toko. ';
                return redirect()->route('cart.success', $order->id)->with('success', $successMessage);
            } else {
                $successMessage .= 'Pesanan Anda akan segera diproses. ';
                return redirect()->route('cart.success', $order->id)->with('success', $successMessage);
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
            ->where(function ($query) use ($userId, $sessionId) {
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
        return $cartItems->sum(function ($item) {
            $price = $item->product->harga_diskon ?? $item->product->harga;

            // Apply combined board pricing logic
            if ($item->is_combined_order && $item->product->is_combinable) {
                if ($item->combined_quantity) {
                    // Standard combined order (2 or 3 papan) - apply multiplier
                    // For '2 papan = 2x price', it means the base price is multiplied by the combinable_multiplier
                    // The item->quantity for a combined order is expected to be 1 from the frontend logic.
                    return ($price * $item->product->combinable_multiplier) * $item->quantity; // Price for N sets
                } elseif ($item->combined_custom_request) {
                    // Custom request - use base price, admin will adjust manually
                    // For now, we'll use a conservative estimate (3x multiplier) but admin should review
                    return ($price * ($item->product->combinable_multiplier ?? 3)) * $item->quantity;
                }
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
     * Selalu gratis ongkir untuk Padang.
     */
    private function calculateShippingCost(float $distanceKm = 0, bool $isPadang = true): float
    {
        return 0.00;
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

            return redirect()->route('cart.success', $order->id)->with('success', 'Bukti transfer berhasil diunggah. Pesanan Anda akan diverifikasi oleh admin.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer. Silakan coba lagi.');
    }

    public function orderSuccess(Order $order)
    {
        // Ensure the authenticated user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cart.success', compact('order'));
    }
}