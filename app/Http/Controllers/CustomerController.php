<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class CustomerController extends Controller
{
    public function index()
    {
        Log::info('Accessing customer dashboard as user: ' . Auth::id());
        return view('customer.dashboard');
    }

    public function editProfile()
    {
        return view('customer.profile.edit', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('customer.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function orders()
    {
        try {
            $orders = Auth::user()->orders()->with('orderItems.product')->latest()->get();
            return view('customer.orders.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error fetching customer orders: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat memuat pesanan Anda. Silakan coba lagi.');
        }
    }

    public function showOrder(Order $order)
    {
        try {
            // Ensure the authenticated user owns the order
            if ($order->user_id !== Auth::id()) {
                abort(403);
            }

            return view('customer.orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error displaying customer order ' . $order->id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat memuat detail pesanan Anda. Silakan coba lagi.');
        }
    }
}
