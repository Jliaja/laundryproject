<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Batalkan Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #c82333;
        }
        p {
            text-align: center;
            font-size: 16px;
            color: #333;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        .btn-submit {
            background-color: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Konfirmasi Pembatalan</h2>
    <p>Apakah kamu yakin ingin membatalkan pesanan <strong>#{{ $pesanan->id }}</strong>?</p>

    <form method="POST" action="{{ route('user.batalkanpesanan', $pesanan->id) }}">
        @csrf
        @method('PUT')
        <div class="btn-group">
            <a href="{{ route('user.pesanan') }}" class="btn btn-cancel">Kembali</a>
            <button type="submit" class="btn btn-submit" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">Ya, Batalkan</button>
        </div>
    </form>
</div>

</body>
</html>
