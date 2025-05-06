<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
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

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
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
            background-color: #f2f2f2;
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
    </style>
</head>
<body>

<h1>Daftar Pesanan</h1>

@if(session('success'))
    <div class="success-message">
        {{ session('success') }}
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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->sortBy('status') as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->layanan }}</td>
                    <td>{{ $p->jumlah }} kg</td>
                    <td>Rp. {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        @if($p->status == 'selesai' && !$p->metode_pengambilan)
                            <a href="{{ route('user.pilihpengambilan', ['pesanan_id' => $p->id]) }}">Atur Pengambilan</a>
                        @else
                            {{ ucfirst($p->status) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<a class="back-link" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>

</body>
</html>
