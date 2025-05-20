<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .payment-button {
            display: block;
            width: 200px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            margin: 20px auto;
            cursor: pointer;
        }

        .payment-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Bayar Pesanan</h1>

<p>Detail Pesanan:</p>
<ul>
    <li><strong>Layanan:</strong> {{ $pesanan->layanan }}</li>
    <li><strong>Jumlah:</strong> {{ $pesanan->jumlah }} kg</li>
    <li><strong>Total Harga:</strong> Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</li>
</ul>

<form action="{{ route('user.bayar.submit', $pesanan->id) }}" method="POST">
    @csrf
    <button type="submit" class="payment-button">Bayar Sekarang</button>
</form>

</body>
</html>
