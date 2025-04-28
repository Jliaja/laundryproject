<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
</head>
<body>
    <h1>Daftar Pesanan</h1>

    <!-- Debugging: Menampilkan $pesanan -->
    <pre>{{ print_r($pesanan, true) }}</pre>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <p>User ID login: {{ Auth::id() }}</p>
    <p>Jumlah Pesanan: {{ $pesanan->count() }}</p> <!-- Menampilkan jumlah pesanan -->

    <!-- Cek apakah pesanan kosong atau tidak -->
    @if($pesanan->isEmpty())
        <p>Tidak ada pesanan ditemukan.</p>
    @else
        <ul>
            @foreach($pesanan as $p)
                <li>
                    ID: {{ $p->id }} |
                    Layanan: {{ $p->layanan }} |
                    Jumlah: {{ $p->jumlah }} |
                    Tanggal: {{ $p->tanggal }} |
                    Status: {{ $p->status }}
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
