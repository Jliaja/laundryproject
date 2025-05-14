<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Pesanan</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .container {
      max-width: 800px;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
      backdrop-filter: blur(10px);
    }

    h2 {
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 20px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    p {
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    ul {
      list-style: none;
      padding: 0;
      margin-bottom: 30px;
      text-align: left;
    }

    ul li {
      font-size: 1.2rem;
      color: #444;
      margin: 10px 0;
      padding-left: 25px;
      position: relative;
      line-height: 1.5;
    }

    ul li::before {
      content: '✔️';
      position: absolute;
      left: 0;
      color: #28a745;
    }

    .status-pending {
      background-color: #ffc107;
      color: #000;
      padding: 10px 20px;
      border-radius: 30px;
      font-weight: bold;
      margin: 20px 0;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .payment-instruction {
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 30px;
      font-size: 1.1rem;
      line-height: 1.5;
    }

    .button {
      background-color: #28a745;
      color: white;
      padding: 14px 28px;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      font-size: 1.1rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-transform: uppercase;
      margin-top: 15px;
    }

    .button:hover {
      background-color: #218838;
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* Pay button styling */
    .pay-button {
      background-color: #007bff;
      padding: 14px 28px;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      font-size: 1.1rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-transform: uppercase;
      margin-top: 20px;
    }

    .pay-button:hover {
      background-color: #0056b3;
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

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
    <h2>Konfirmasi Pesanan</h2>
    <p>Pesanan Anda berhasil dibuat! Berikut adalah rincian pesanan Anda:</p>

    @isset($pesanan)
      <ul>
        <li><strong>Nama Pelanggan:</strong> {{ $pesanan->nama_pelanggan }}</li>
        <li><strong>Layanan:</strong> {{ $pesanan->layanan }}</li>
        <li><strong>Jumlah:</strong> {{ $pesanan->jumlah }} kg</li>
        <li><strong>Tanggal:</strong> {{ $pesanan->tanggal }}</li>
      </ul>

      <div class="status-pending">Status: Pending Pembayaran</div>

      <div class="payment-instruction">
        Silakan selesaikan pembayaran Anda untuk memproses pesanan.<br>
        Anda dapat melakukan pembayaran melalui metode yang tersedia di halaman pembayaran.
      </div>

      <!-- Pay Now Button -->
      <a href="{{ route('user.bayar', ['id' => $pesanan->id]) }}" class="pay-button">Bayar</a>


    @else
      <p>Pesanan tidak ditemukan!</p>
    @endisset

    <a href="{{ route('user.daftarpesanan') }}" class="button">Daftar Pesanan Kamu</a>
  </div>

</body>
</html>
