<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use App\Models\Setting; // Untuk mengambil pengaturan API jika ada

class WhatsAppService
{
    public function sendNewOrderNotification(Order $order, string $recipientPhoneNumber)
    {
        // Implementasi sebenarnya akan menggunakan API WhatsApp eksternal (misalnya Twilio, Chat API, Wablas).
        // Untuk demo, kita hanya akan mencatat pesan ke log.

        $message = "*PESANAN BARU DITERIMA (Aresha Florist)*\n\n";
        $message .= "Halo Admin,\n";
        $message .= "Anda telah menerima pesanan baru dari *{$order->customer_name}*.\n\n";
        $message .= "*Detail Pesanan:*\n";
        $message .= "• Nomor Pesanan: {$order->order_number}\n";
        $message .= "• Total Pembayaran: Rp" . number_format($order->grand_total, 0, ',', '.') . "\n";
        $message .= "• Metode Pembayaran: ";
        if ($order->payment_method == 'cod') {
            $message .= "Cash on Delivery\n";
        } elseif ($order->payment_method == 'transfer') {
            $message .= "Transfer Bank\n";
        } elseif ($order->payment_method == 'payment_gateway') {
            $message .= "Payment Gateway\n";
        } else {
            $message .= "Cash\n";
        }
        $message .= "• Status Pembayaran: " . ucfirst(str_replace('_', ' ', $order->payment_status)) . "\n";
        $message .= "• Status Pesanan: " . ucfirst(str_replace('_', ' ', $order->order_status)) . "\n\n";
        $message .= "*Alamat Pengiriman:*\n";
        $message .= "{$order->customer_address}\n\n";
        $message .= "Lihat detail pesanan di Admin Panel: " . route('admin.orders.show', $order->id) . "\n\n";
        $message .= "Terima kasih,\nTim Aresha Florist";

        Log::info("Simulasi pengiriman notifikasi WhatsApp pesanan baru ke: {$recipientPhoneNumber}", [
            'order_id' => $order->id,
            'message' => $message,
        ]);

        // Contoh integrasi dengan API eksternal (uncomment dan sesuaikan)
        // $whatsappApiKey = Setting::getSetting('whatsapp_api_key');
        // $whatsappApiUrl = Setting::getSetting('whatsapp_api_url');

        // if ($whatsappApiKey && $whatsappApiUrl) {
        //     try {
        //         $response = Http::post($whatsappApiUrl, [
        //             'api_key' => $whatsappApiKey,
        //             'to' => $recipientPhoneNumber,
        //             'message' => $message,
        //         ]);
        //         if ($response->successful()) {
        //             Log::info('WhatsApp new order notification sent successfully.', ['order_id' => $order->id]);
        //             return true;
        //         } else {
        //             Log::error('Failed to send WhatsApp new order notification: ' . $response->body(), ['order_id' => $order->id]);
        //             return false;
        //         }
        //     } catch (\Exception $e) {
        //         Log::error('Exception while sending WhatsApp new order notification: ' . $e->getMessage(), ['order_id' => $order->id]);
        //         return false;
        //     }
        // } else {
        //     Log::warning('WhatsApp API credentials not set. New order notification not sent.');
        //     return false;
        // }
        return true; // Asumsi berhasil untuk demo
    }

    public function sendOrderConfirmation(Order $order, string $recipientPhoneNumber)
    {
        // Implementasi sebenarnya akan menggunakan API WhatsApp eksternal.
        // Untuk demo, kita hanya akan mencatat pesan ke log.

        $message = "*KONFIRMASI PESANAN (Aresha Florist)*\n\n";
        $message .= "Halo *{$order->customer_name}*,\n";
        $message .= "Terima kasih atas pesanan Anda! Pesanan Anda dengan nomor *{$order->order_number}* telah berhasil kami terima.\n\n";
        $message .= "*Detail Pesanan Anda:*\n";
        $message .= "• Nomor Pesanan: {$order->order_number}\n";
        $message .= "• Tanggal Pesanan: {$order->created_at->format('d M Y H:i')}\n";
        $message .= "• Total Pembayaran: Rp" . number_format($order->grand_total, 0, ',', '.') . "\n";
        $message .= "• Metode Pembayaran: ";
        if ($order->payment_method == 'cod') {
            $message .= "Cash on Delivery\n";
        } elseif ($order->payment_method == 'transfer') {
            $message .= "Transfer Bank\n";
        } elseif ($order->payment_method == 'payment_gateway') {
            $message .= "Payment Gateway\n";
        } else {
            $message .= "Cash\n";
        }
        $message .= "• Status Pembayaran: " . ucfirst(str_replace('_', ' ', $order->payment_status)) . "\n";
        $message .= "• Status Pesanan: " . ucfirst(str_replace('_', ' ', $order->order_status)) . "\n\n";

        if ($order->payment_method === 'transfer' && $order->payment_status === 'pending_transfer') {
            $bankName = Setting::getSetting('bank_name', '[Nama Bank Belum Diatur]');
            $bankAccountNumber = Setting::getSetting('bank_account_number', '[Nomor Rekening Belum Diatur]');
            $message .= "Mohon segera lakukan pembayaran via transfer bank ke rekening kami:\n";
            $message .= "• Bank: {$bankName}\n";
            $message .= "• No. Rekening: {$bankAccountNumber}\n";
            $message .= "• Atas Nama: Aresha Florist\n\n";
            $message .= "Setelah transfer, silakan unggah bukti pembayaran Anda melalui link berikut: " . route('cart.payment.confirm', $order->id) . "\n";
        } elseif ($order->payment_method === 'payment_gateway' && $order->payment_status === 'pending_payment_gateway') {
            $message .= "Pembayaran Anda sedang dalam proses verifikasi melalui Payment Gateway.\n";
            $message .= "Anda dapat mengecek status pesanan Anda di sini: " . route('customer.orders.show', $order->id) . "\n";
        } else {
            $message .= "Anda dapat mengecek status pesanan Anda di sini: " . route('customer.orders.show', $order->id) . "\n";
        }
        $message .= "\nTerima kasih,\nTim Aresha Florist";

        Log::info("Simulasi pengiriman notifikasi WhatsApp konfirmasi pesanan ke: {$recipientPhoneNumber}", [
            'order_id' => $order->id,
            'message' => $message,
        ]);

        // Contoh integrasi dengan API eksternal (uncomment dan sesuaikan)
        // $whatsappApiKey = Setting::getSetting('whatsapp_api_key');
        // $whatsappApiUrl = Setting::getSetting('whatsapp_api_url');

        // if ($whatsappApiKey && $whatsappApiUrl) {
        //     try {
        //         $response = Http::post($whatsappApiUrl, [
        //             'api_key' => $whatsappApiKey,
        //             'to' => $recipientPhoneNumber,
        //             'message' => $message,
        //         ]);
        //         if ($response->successful()) {
        //             Log::info('WhatsApp order confirmation sent successfully.', ['order_id' => $order->id]);
        //             return true;
        //         } else {
        //             Log::error('Failed to send WhatsApp order confirmation: ' . $response->body(), ['order_id' => $order->id]);
        //             return false;
        //         }
        //     } catch (\Exception $e) {
        //         Log::error('Exception while sending WhatsApp order confirmation: ' . $e->getMessage(), ['order_id' => $order->id]);
        //         return false;
        //     }
        // } else {
        //     Log::warning('WhatsApp API credentials not set. Order confirmation not sent.');
        //     return false;
        // }
        return true; // Asumsi berhasil untuk demo
    }
}

