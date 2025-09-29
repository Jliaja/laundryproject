<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-dark);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            background-color: white;
            padding: 25px;
            border-radius: 16px;
            max-width: 1200px;
            margin: 0 auto;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .success-message, .error-message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .pay-button, .pay-button1 {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            min-width: 90px;
            font-size: 14px;
            text-align: center;
        }

        .pay-button:hover, .pay-button1:hover {
            background-color: #218838;
        }

        .pay-button[disabled] {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .action-buttons form,
        .action-buttons a {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Pesanan</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    @if($pesanan->isEmpty())
        <p style="text-align: center;">Tidak ada pesanan ditemukan.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Pesanan ID</th>
                <th>Layanan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Status Pesanan</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
                <th>Invoice</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pesanan->sortByDesc('tanggal') as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->layanan }}</td>
                    <td>{{ $p->jumlah }} kg</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        @if($p->status == 'selesai' && empty($p->metode_pengambilan))
                            <a href="{{ route('user.pilihpengambilan', ['pesanan_id' => $p->id]) }}">Atur Pengambilan</a>
                        @else
                            {{ ucfirst($p->status) }}
                        @endif
                    </td>
                    <td>{{ ucfirst($p->status_pembayaran) }}</td>
                    <td>
                        <div class="action-buttons">
                            @if($p->status === 'pending' && $p->status_pembayaran === 'pending' && $p->total_harga >= 0)
                                <form action="{{ route('user.batalkanpesanan', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="pay-button" style="background-color: red;">
                                        Batalkan
                                    </button>
                                </form>
                            @elseif($p->status === 'dibatalkan')
                                <span style="color: red;">Dibatalkan</span>
                            @elseif($p->status_pembayaran === 'gagal')
                                <a href="{{ route('user.pembayaran', $p->id) }}" class="pay-button" style="background-color:#007bff;">
                                    Coba Bayar Lagi
                                </a>
                                <form action="{{ route('user.batalkanpesanan', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="pay-button" style="background-color: red;">
                                        Batalkan
                                    </button>
                                </form>
                            @elseif($p->status_pembayaran !== 'selesai' && $p->total_harga > 0)
                                <a href="{{ route('user.pembayaran', $p->id) }}" class="pay-button" style="background-color:#007bff;">
                                    Bayar
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($p->status == 'selesai' && $p->status_pembayaran == 'selesai')
                            <a href="{{ route('user.downloadinvoice', $p->id) }}" class="pay-button1" style="background-color:#007bff;">
                                Download Invoice
                            </a>
                        @elseif($p->status == 'selesai' && $p->status_pembayaran != 'selesai')
                            <span style="font-size: 12px; color: red;">Selesaikan pembayaran</span>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <a class="back-link" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>
</div>

</body>
</ht
