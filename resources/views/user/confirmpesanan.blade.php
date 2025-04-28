<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Terkonfirmasi</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #4ac6e8, #a1e0f3);
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 60px auto;
      background-color: #ffffffd9;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    p {
      font-size: 18px;
      color: #333;
      text-align: center;
    }

    .button {
      display: block;
      text-align: center;
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
    }

    .button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Pesanan Berhasil Dibuat</h2>
    <p>Pesanan Anda berhasil dibuat! Berikut adalah rincian pesanan:</p>

    @isset($pesanan)
      <ul>
        <li>Nama Pelanggan: {{ $pesanan->nama_pelanggan }}</li>
        <li>Layanan: {{ $pesanan->layanan }}</li>
        <li>Jumlah: {{ $pesanan->jumlah }} kg</li>
        <li>Tanggal: {{ $pesanan->tanggal }}</li>
      </ul>
    @else
      <p>Pesanan tidak ditemukan!</p>
    @endisset

    <a href="{{ route('user.dashboard') }}" class="button">Kembali ke Dashboard</a>
  </div>

</body>
</html>
