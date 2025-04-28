<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            padding: 0;
            list-style: none;
        }
        li {
            background: #e8f0fe;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Riwayat Pesanan</h2>
    @if(count($pesanan) > 0)
        <ul>
            @foreach($pesanan as $p)
                <li>ID: {{ $p->id_pesanan }} - Tanggal: {{ $p->tanggal }}</li>
            @endforeach
        </ul>
    @else
        <p>Belum ada riwayat pesanan.</p>
    @endif
</div>
</body>
</html>
