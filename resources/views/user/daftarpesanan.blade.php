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
        .user-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .pesanan-list {
            list-style-type: none;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }
        .pesanan-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="user-info">
        <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
        <p><strong>Jumlah Pesanan:</strong> {{ $pesanan->count() }}</p>
    </div>

    <!-- Cek apakah pesanan kosong atau tidak -->
    @if($pesanan->isEmpty())
        <p style="text-align: center;">Tidak ada pesanan ditemukan.</p>
    @else
        <ul class="pesanan-list">
            @foreach($pesanan as $p)
                <li class="pesanan-item">
                    <h4>Pesanan ID: {{ $p->id }}</h4>
                    <p><strong>Layanan:</strong> {{ $p->layanan }}</p>
                    <p><strong>Jumlah:</strong> {{ $p->jumlah }} kg</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($p->status) }}</p>
                </li>
            @endforeach
        </ul>
    @endif

    <a class="back-link" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>

</body>
</html>
