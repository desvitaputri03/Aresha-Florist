<p>Halo Admin,</p>

<p>Anda telah menerima pesanan baru dari <strong>{{ $order->customer_name }}</strong>.</p>

<p><strong>Detail Pesanan:</strong></p>
<ul>
    <li><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</li>
    <li><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</li>
    <li><strong>Total Pembayaran:</strong> Rp{{ number_format($order->grand_total, 0, ',', '.') }}</li>
    <li><strong>Metode Pembayaran:</strong> {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : ($order->payment_method == 'transfer' ? 'Transfer Bank' : ($order->payment_method == 'payment_gateway' ? 'Payment Gateway' : 'Cash')) }}</li>
    <li><strong>Status Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</li>
    <li><strong>Status Pesanan:</strong> {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</li>
</ul>

<p><strong>Alamat Pengiriman:</strong></p>
<p>{{ $order->customer_address }}</p>

<p><strong>Item Pesanan:</strong></p>
<ul>
    @foreach ($order->orderItems as $item)
        <li>{{ $item->product->name }} ({{ $item->quantity }}x) - Rp{{ number_format($item->total_price, 0, ',', '.') }}</li>
    @endforeach
</ul>

<p>Silakan masuk ke panel admin untuk melihat detail pesanan selengkapnya dan memprosesnya.</p>
<p><a href="{{ route('admin.orders.show', $order->id) }}">Lihat Pesanan di Admin Panel</a></p>

<p>Terima kasih,</p>
<p>Tim Aresha Florist</p>

