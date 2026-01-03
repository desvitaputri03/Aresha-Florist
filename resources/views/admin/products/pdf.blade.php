<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk - Aresha Florist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            color: #C2185B;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <h2>Laporan Daftar Produk</h2>
    <p style="text-align: center; margin-bottom: 20px;">
        <strong>Aresha Florist</strong><br>
        Dicetak pada: {{ now()->format('d F Y H:i:s') }}
    </p>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Produk</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 12%;" class="text-right">Harga Normal</th>
                <th style="width: 12%;" class="text-right">Harga Diskon</th>
                <th style="width: 8%;" class="text-center">Stok</th>
                <th style="width: 10%;" class="text-center">Dapat Digabungkan</th>
                <th style="width: 8%;" class="text-center">Pengali</th>
                <th style="width: 10%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td class="text-right">Rp{{ number_format($product->harga, 0, ',', '.') }}</td>
                <td class="text-right">
                    @if($product->harga_diskon)
                        Rp{{ number_format($product->harga_diskon, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">{{ $product->stok }}</td>
                <td class="text-center">{{ $product->is_combinable ? 'Ya' : 'Tidak' }}</td>
                <td class="text-center">{{ $product->combinable_multiplier ?? '-' }}</td>
                <td class="text-center">
                    @if($product->stok > 0)
                        Aktif
                    @else
                        Tidak Aktif
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada produk</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" style="text-align: right; font-weight: bold; padding-top: 10px;">
                    Total Produk: {{ $products->count() }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>


