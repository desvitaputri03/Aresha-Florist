@extends('layouts.admin')

@section('title', 'Cetak Laporan Pesanan')

@section('content')
<h2 style="text-align:center;">Laporan Pesanan Terbaru</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="6" style="font-size:13px;">
    <thead>
        <tr>
            <th>No</th>
            <th>No. Pesanan</th>
            <th>Nama Customer</th>
            <th>Email</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->user ? $order->user->name : $order->customer_name }}</td>
            <td>{{ $order->user ? $order->user->email : $order->customer_email }}</td>
            <td>Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
            <td>{{ ucfirst($order->order_status) }}</td>
            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
