<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Payment Gateway Webhook received.', $request->all());

        // --- Placeholder untuk Verifikasi Webhook Signature (Penting untuk Keamanan) ---
        // Setiap Payment Gateway memiliki cara verifikasi signature yang berbeda.
        // Anda harus mengimplementasikan logika verifikasi sesuai dokumentasi Payment Gateway yang Anda gunakan.
        // Contoh: $signature = $request->header('X-Signature');
        // if (!$this->verifyWebhookSignature($request->getContent(), $signature)) {
        //     Log::warning('Webhook signature verification failed.');
        //     return response()->json(['message' => 'Invalid signature'], 403);
        // }

        $payload = $request->all();

        // Asumsi payload memiliki order_id dan status
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentGatewayOrderId = $payload['payment_gateway_order_id'] ?? null; // ID transaksi dari payment gateway

        if (!$orderId || !$transactionStatus || !$paymentGatewayOrderId) {
            Log::warning('Invalid webhook payload.', $payload);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning('Order not found for webhook: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Perbarui status pesanan berdasarkan transactionStatus dari Payment Gateway
        switch ($transactionStatus) {
            case 'settlement':
            case 'capture':
                $order->payment_status = 'paid';
                $order->order_status = 'processing';
                break;
            case 'pending':
                $order->payment_status = 'pending_payment_gateway';
                $order->order_status = 'pending_payment_gateway';
                break;
            case 'deny':
            case 'cancel':
            case 'expire':
                $order->payment_status = 'failed';
                $order->order_status = 'cancelled';
                break;
            default:
                Log::warning('Unknown transaction status from payment gateway: ' . $transactionStatus, ['order_id' => $orderId]);
                return response()->json(['message' => 'Unknown transaction status'], 200);
        }

        $order->payment_gateway_order_id = $paymentGatewayOrderId;
        $order->payment_gateway_status = $transactionStatus;
        $order->save();

        Log::info('Order status updated successfully via webhook.', [
            'order_id' => $order->id,
            'new_payment_status' => $order->payment_status,
            'new_order_status' => $order->order_status,
        ]);

        return response()->json(['message' => 'Webhook handled successfully'], 200);
    }

    // --- Placeholder untuk Metode Verifikasi Signature Webhook ---
    // private function verifyWebhookSignature($payload, $signature) {
    //     // Implementasi ini sangat bergantung pada Payment Gateway yang digunakan.
    //     // Anda mungkin perlu menggunakan kunci rahasia dari Payment Gateway Anda.
    //     // Contoh sederhana (JANGAN GUNAKAN DI PRODUKSI):
    //     // $expectedSignature = hash_hmac('sha256', $payload, 'YOUR_PG_WEBHOOK_SECRET');
    //     // return hash_equals($expectedSignature, $signature);
    //     return true; // Untuk demo, selalu kembalikan true
    // }
}
