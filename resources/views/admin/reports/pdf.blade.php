<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Aresha Florist</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #C2185B;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #C2185B;
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 12px;
        }
        .summary-box {
            background-color: #FCE4EC;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #F8BBD9;
        }
        .summary-title {
            color: #C2185B;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
            border-bottom: 1px solid #F8BBD9;
            padding-bottom: 5px;
        }
        .summary-table {
            width: 100%;
            border: none;
        }
        .summary-table td {
            border: none;
            padding: 3px 0;
            font-size: 12px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th {
            background-color: #C2185B;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #C2185B;
            text-transform: uppercase;
        }
        table.data-table td {
            padding: 8px;
            border: 1px solid #eee;
            vertical-align: middle;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge-paid {
            color: #2e7d32;
            font-weight: bold;
            text-transform: uppercase;
        }
        .total-row {
            background-color: #FCE4EC !important;
            font-weight: bold;
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan Aresha Florist</h1>
        <p>Periode: <strong>{{ $periodeStr }}</strong></p>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Eksekutif</div>
        <table class="summary-table">
            <tr>
                <td style="width: 150px;">Total Pesanan Sukses</td>
                <td>: <strong>{{ $totalOrders }} Pesanan</strong></td>
            </tr>
            <tr>
                <td>Total Pendapatan Bersih</td>
                <td>: <strong style="color: #C2185B; font-size: 16px;">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ now()->translatedFormat('d F Y H:i') }} WIB</td>
            </tr>
        </table>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">No. Pesanan</th>
                <th style="width: 20%;">Nama Pelanggan</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;" class="text-right">Total Transaksi</th>
                <th style="width: 10%;" class="text-center">Status</th>
                <th style="width: 10%;" class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td style="font-family: 'Courier New', Courier, monospace; font-weight: bold;">{{ $order->order_number }}</td>
                <td>{{ $order->user ? $order->user->name : ($order->customer_name ?? 'Guest') }}</td>
                <td>{{ $order->user ? $order->user->email : ($order->customer_email ?? '-') }}</td>
                <td class="text-right">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                <td class="text-center badge-paid">PAID</td>
                <td class="text-center">{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 30px;">
                    <em>Tidak ada data penjualan yang ditemukan untuk periode ini.</em>
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($orders->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN (GRAND TOTAL)</td>
                <td class="text-right" style="color: #C2185B;">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>
    
    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Aresha Florist.</p>
        <p>Dicetak oleh: Admin | &copy; {{ date('Y') }} Aresha Florist</p>
    </div>
</body>
</html>