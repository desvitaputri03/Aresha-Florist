<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan - Aresha Florist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #C2185B;
            margin-bottom: 10px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #C2185B;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Aresha Florist</h2>
    <div class="header-info">
        <strong>Periode: {{ $periodeStr }}</strong><br>
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">No. Pesanan</th>
                <th style="width: 20%;">Nama Customer</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 15%;" class="text-right">Total</th>
                <th style="width: 12%;" class="text-center">Status</th>
                <th style="width: 13%;" class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user ? $order->user->name : $order->customer_name }}</td>
                <td>{{ $order->user ? $order->user->email : $order->customer_email }}</td>
                <td class="text-right">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                <td class="text-center">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</td>
                <td class="text-center">{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data penjualan pada periode ini</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold; padding-top: 10px;">
                    Total Unit Terjual:
                </td>
                <td colspan="3" style="font-weight: bold; padding-top: 10px;">
                    {{ $totalOrders }} Pesanan
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">
                    TOTAL PENDAPATAN:
                </td>
                <td colspan="3" style="font-weight: bold; color: #C2185B;">
                    Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Laporan ini dibuat otomatis oleh sistem Aresha Florist</p>
    </div>
</body>
</html>
