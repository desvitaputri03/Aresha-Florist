<p>Halo <strong>{{ $order->customer_name }}</strong>,</p>

<p>Terima kasih atas pesanan Anda di Aresha Florist!</p>
<p>Pesanan Anda dengan nomor <strong>{{ $order->order_number }}</strong> telah berhasil kami terima.</p>

<p><strong>Detail Pesanan Anda:</strong></p>
<ul>
    <li><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</li>
    <li><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</li>
    <li><strong>Total Pembayaran:</strong> Rp{{ number_format($order->grand_total, 0, ',', '.') }}</li>
    <li><strong>Metode Pembayaran:</strong> {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : ($order->payment_method == 'transfer' ? 'Transfer Bank' : ($order->payment_method == 'payment_gateway' ? 'Payment Gateway' : 'Cash')) }}</li>
    <li><strong>Status Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</li>
    <li><strong>Status Pesanan:</strong> {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</li>
</ul>

@if($order->payment_method === 'transfer' && $order->payment_status === 'pending_transfer')
    <p>Mohon segera lakukan pembayaran via transfer bank ke rekening kami:</p>
    <ul>
        <li><strong>Bank:</strong> {{ \App\Models\Setting::getSetting('bank_name', '[Nama Bank Belum Diatur]') }}</li>
        <li><strong>No. Rekening:</strong> {{ \App\Models\Setting::getSetting('bank_account_number', '[Nomor Rekening Belum Diatur]') }}</li>
        <li><strong>Atas Nama:</strong> Aresha Florist</li>
    </ul>
    <p>Setelah transfer, silakan unggah bukti pembayaran Anda melalui halaman konfirmasi pembayaran:</p>
    <p><a href="{{ route('cart.payment.confirm', $order->id) }}">Unggah Bukti Pembayaran</a></p>
@elseif($order->payment_method === 'payment_gateway' && $order->payment_status === 'pending_payment_gateway')
    <p>Pembayaran Anda sedang dalam proses verifikasi melalui Payment Gateway.</p>
    <p>Anda dapat mengecek status pesanan Anda di sini:</p>
    <p><a href="{{ route('customer.orders.show', $order->id) }}">Lihat Detail Pesanan</a></p>
@elseif($order->payment_method === 'cod')
    <p>Pesanan Anda akan segera diproses. Pembayaran akan dilakukan saat barang diterima.</p>
    <p>Anda dapat mengecek status pesanan Anda di sini:</p>
    <p><a href="{{ route('customer.orders.show', $order->id) }}">Lihat Detail Pesanan</a></p>
@else
    <p>Pesanan Anda akan segera diproses. Anda dapat mengecek status pesanan Anda di sini:</p>
    <p><a href="{{ route('customer.orders.show', $order->id) }}">Lihat Detail Pesanan</a></p>
@endif

<p>Terima kasih,</p>
<p>Tim Aresha Florist</p>

