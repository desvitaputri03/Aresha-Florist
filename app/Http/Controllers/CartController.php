<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderNotification;
use App\Mail\CustomerOrderConfirmation;
use App\Services\WhatsAppService;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);
        return view('cart.index', compact('cartItems', 'total'));
    }

    // FUNGSI UTAMA: TAMBAH KE KERANJANG (ANTI-GAGAL)
    public function add(Request $request, Product $product)
    {
        // 1. Validasi Stok Sederhana
        if ($product->stok < 1) {
            return back()->with('error', 'Maaf, stok produk ini sedang habis.');
        }

        $userId = Auth::id();
        $sessionId = session()->getId();
        $quantity = $request->input('quantity', 1);

        // Ambil inputan user (jika ada)
        $isCombined = $request->input('is_combined_order_input', 0);
        $combinedQty = $request->input('combined_quantity_input');
        $combinedReq = $request->input('combined_custom_request_input');

        try {
            // === PERCOBAAN 1: CARA LENGKAP (FITUR BARU) ===
            // Kita coba cari dan simpan dengan kolom-kolom baru (is_combined_order, dll)
            
            $existingCart = Cart::where('product_id', $product->id)
                ->where('is_combined_order', $isCombined) // Ini akan error jika kolom belum ada di DB
                ->where(function ($q) use ($userId, $sessionId) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        $q->where('session_id', $sessionId);
                    }
                })
                ->first();

            if ($existingCart) {
                // Update jumlah
                $existingCart->quantity = $quantity;
                $existingCart->save();
            } else {
                // Buat baru lengkap
                $cart = new Cart();
                $cart->user_id = $userId;
                $cart->session_id = $sessionId;
                $cart->product_id = $product->id;
                $cart->quantity = $quantity;
                $cart->is_combined_order = $isCombined; // Potensi error jika kolom hilang
                $cart->combined_quantity = $combinedQty;
                $cart->combined_custom_request = $combinedReq;
                $cart->save();
            }

        } catch (\Exception $e) {
            // === PERCOBAAN 2: JALUR PENYELAMAT (FALLBACK) ===
            // Jika masuk sini, berarti Database Hosting belum support fitur baru.
            // JANGAN PANIK. Kita pakai cara lama yang penting barang masuk.
            
            try {
                // Cari item keranjang sederhana (abaikan fitur gabungan)
                $simpleCart = Cart::where('product_id', $product->id)
                    ->where(function($q) use ($userId, $sessionId) {
                        if ($userId) $q->where('user_id', $userId);
                        else $q->where('session_id', $sessionId);
                    })
                    ->first();

                if ($simpleCart) {
                    // Update jumlah saja
                    $simpleCart->quantity = $quantity;
                    $simpleCart->save();
                } else {
                    // Buat baru TANPA kolom aneh-aneh (Hanya kolom standar)
                    $simpleCart = new Cart();
                    $simpleCart->user_id = $userId;
                    $simpleCart->session_id = $sessionId;
                    $simpleCart->product_id = $product->id;
                    $simpleCart->quantity = $quantity;
                    $simpleCart->save();
                }
            } catch (\Exception $criticalError) {
                // Jika masih gagal juga, baru kita menyerah
                return back()->with('error', 'Gagal menambahkan ke keranjang. Silakan hubungi admin.');
            }
        }

        // Cek apakah user ingin langsung checkout
        if ($request->filled('redirect') && $request->input('redirect') === 'checkout') {
            return redirect()->route('cart.checkout')->with('success', 'Produk berhasil ditambahkan.');
        }

        return back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item dihapus!');
    }

    public function clear()
    {
        $this->getCartItems()->each->delete();
        return back()->with('success', 'Keranjang dikosongkan!');
    }

    public function checkout()
    {
        $cartItems = $this->getCartItems();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $total = $this->calculateTotal($cartItems);
        
        // Data Wilayah (handle jika tabel belum di-seed/exist)
        $provinces = class_exists(Province::class) ? Province::all(['id', 'name']) : collect();
        $sumateraBarat = class_exists(Province::class) ? Province::where('name', 'Sumatera Barat')->first() : null;
        $kotaPadang = class_exists(Regency::class) ? Regency::where('name', 'Kota Padang')->first() : null;
        
        $regencies = $sumateraBarat ? $sumateraBarat->regencies()->get(['id', 'name']) : collect();
        $districts = $kotaPadang ? $kotaPadang->districts()->get(['id', 'name', 'postal_code']) : collect();

        return view('cart.checkout', compact('cartItems', 'total', 'provinces', 'regencies', 'districts'));
    }

     public function processCheckout(Request $request)
    {
        // Validasi Simple
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'payment_method' => 'required'
        ]);

        $cartItems = $this->getCartItems();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index');

        // Cari Admin
        $admin = User::where('is_admin', true)->first();
        $adminId = $admin ? $admin->id : 1; 

        DB::beginTransaction();
        try {
            $totalAmount = $this->calculateTotal($cartItems);
            
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()), // Fallback generator
                'user_id' => Auth::id(),
                'admin_id' => $adminId,
                'customer_name' => $request->nama,
                'customer_email' => $request->email ?? ($request->user()->email ?? 'guest@aresha.com'),
                'customer_phone' => $request->telepon,
                'customer_address' => $request->alamat,
                'notes' => $request->catatan,
                'recipient_name' => $request->recipient_name ?? '-',
                'event_type' => $request->event_type ?? 'Umum',
                'custom_message' => $request->custom_message ?? '-',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending', 
                'order_status' => 'pending',
                'total_amount' => $totalAmount,
                'grand_total' => $totalAmount, // Ongkir 0
                'delivery_date' => $request->delivery_date ?? now()->addDay(),
            ]);

            foreach ($cartItems as $cartItem) {
                $price = $cartItem->product->harga_diskon ?? $cartItem->product->harga;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $price,
                    'total_price' => $price * $cartItem->quantity,
                ]);

                // Kurangi stok (Optional: dibungkus try catch biar ga error kalau minus)
                try {
                    $cartItem->product->decrement('stok', $cartItem->quantity);
                } catch (\Exception $e) {}
            }

            // Hapus keranjang
            $this->getCartItems()->each->delete();

            DB::commit();
            return redirect()->route('cart.success', $order->id)->with('success', 'Pesanan berhasil!');

        } catch (\Exception $e) {
            DB::rollback();
            // Log::error('Checkout Error: ' . $e->getMessage()); // Uncomment for debug
            return redirect()->route('cart.index')->with('error', 'Gagal memproses pesanan. Pastikan data lengkap.');
        }
    }

    private function getCartItems()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return Cart::with('product')
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) $query->where('user_id', $userId);
                else $query->where('session_id', $sessionId);
            })
            ->get();
    }

    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            $price = $item->product->harga_diskon ?? $item->product->harga;
            return $price * $item->quantity;
        });
    }

    public function getCartCount()
    {
        $cartItems = $this->getCartItems();
        return response()->json(['count' => $cartItems->sum('quantity')]);
    }

    // Fungsi-fungsi lain tetap ada agar tidak error route not found
    public function showPaymentConfirmation(Order $order) {
        if ($order->user_id !== Auth::id()) abort(403);
        $bankAccountNumber = '-'; 
        $bankName = '-';
        return view('cart.payment_confirmation', compact('order', 'bankAccountNumber', 'bankName'));
    }

    public function uploadPaymentProof(Request $request, Order $order) {
         if ($order->user_id !== Auth::id()) abort(403);
        if ($request->hasFile('proof_of_transfer_image')) {
            $path = $request->file('proof_of_transfer_image')->store('payment_proofs', 'public');
            $order->update(['proof_of_transfer_image' => $path, 'payment_status' => 'awaiting_admin_approval']);
            return redirect()->route('cart.success', $order->id);
        }
        return back();
    }

    public function orderSuccess(Order $order) {
         if ($order->user_id !== Auth::id()) abort(403);
        return view('cart.success', compact('order'));
    }
}