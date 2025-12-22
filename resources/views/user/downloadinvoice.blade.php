<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $pesanan->id }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            background: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            padding: 16px;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #1e88e5;
        }

        .header span {
            font-size: 12px;
            color: #777;
        }

        /* CARD */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 16px;
        }

        .row {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .label {
            color: #777;
        }

        .value {
            font-weight: bold;
            margin-top: 2px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            background: #f5f7fa;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        /* TOTAL */
        .total {
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            color: #1e88e5;
            margin-top: 12px;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #888;
            margin-top: 24px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- HEADER -->
    <div class="header">
        <h1>Laundry Mobile</h1>
        <span>Invoice Pembayaran</span>
    </div>

    <!-- INFO CARD -->
    <div class="card">
        <div class="row">
            <div class="label">Invoice ID</div>
            <div class="value">#{{ $pesanan->id }}</div>
        </div>

        <div class="row">
            <div class="label">Nama</div>
            <div class="value">{{ $pesanan->user->username ?? '-' }}</div>
        </div>

        <div class="row">
            <div class="label">Tanggal</div>
            <div class="value">
                {{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d M Y') }}
            </div>
        </div>
    </div>

    <!-- DETAIL CARD -->
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Jumlah</th>
                    <th style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pesanan->layanan }}</td>
                    <td>{{ $pesanan->jumlah }} kg</td>
                    <td style="text-align:right">
                        Rp {{ number_format($pesanan->total_akhir,0,',','.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total: Rp {{ number_format($pesanan->total_akhir,0,',','.') }}
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Terima kasih telah menggunakan Laundry Mobile.<br>
        Invoice ini dibuat otomatis oleh sistem.
    </div>

</div>

</body>
</html>
