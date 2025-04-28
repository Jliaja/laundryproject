<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Terkonfirmasi</title>
  <style>
    /* Reset margin dan padding */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Background halaman */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #4ac6e8, #a1e0f3);
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Container utama */
    .container {
      max-width: 800px;
      background-color: #ffffffd9;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    /* Judul utama */
    h2 {
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 20px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    /* Styling teks utama */
    p {
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    /* Styling list rincian pesanan */
    ul {
      list-style: none;
      padding: 0;
      margin-bottom: 30px;
    }

    ul li {
      font-size: 1.2rem;
      color: #444;
      margin: 10px 0;
      padding-left: 25px;
      position: relative;
    }

    ul li::before {
      content: '✔️';
      position: absolute;
      left: 0;
      color: #28a745;
    }

    /* Tombol Kembali ke Dashboard */
    .button {
      background-color: #28a745;
      color: white;
      padding: 12px 25px;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      font-size: 1.1rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .button:hover {
      background-color: #218838;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Animasi Fade-in */
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

  </style>
</head>
<body>

  <div class="container">
    <h2>Pesanan Berhasil Dibuat</h2>
    <p>Pesanan Anda berhasil dibuat! Berikut adalah rincian pesanan:</p>

    @isset($pesanan)
      <ul>
        <li><strong>Nama Pelanggan:</strong> {{ $pesanan->nama_pelanggan }}</li>
        <li><strong>Layanan:</strong> {{ $pesanan->layanan }}</li>
        <li><strong>Jumlah:</strong> {{ $pesanan->jumlah }} kg</li>
        <li><strong>Tanggal:</strong> {{ $pesanan->tanggal }}</li>
      </ul>
    @else
      <p>Pesanan tidak ditemukan!</p>
    @endisset

    <a href="{{ route('user.dashboard') }}" class="button">Kembali ke Dashboard</a>
  </div>

</body>
</html>
