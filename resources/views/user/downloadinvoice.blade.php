<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $pesanan->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        h1 { text-align: center; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Invoice Pesanan</h1>

    <p><strong>Invoice ID:</strong> {{ $pesanan->id }}</p>
    <p><strong>Nama:</strong> {{ $pesanan->user->username ?? '' }}</p>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Jumlah</th>
                <th>Harga Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $pesanan->layanan }}</td>
                <td>{{ $pesanan->jumlah }} kg</td>
                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="total">Total: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
</body>
</html>
