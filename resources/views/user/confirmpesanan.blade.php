<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Konfirmasi Pesanan</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: 
        linear-gradient(rgba(220, 233, 249, 0.85), rgba(244, 248, 251, 0.85)),
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      overflow: auto;
      color: #333;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.95);
      max-width: 600px;
      width: 100%;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 0.8s ease-in-out forwards;
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      color: #2c3e50;
    }

    h2 {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 25px;
      letter-spacing: 1.2px;
      color: #004a99;
    }

    p {
      font-size: 1.15rem;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    ul {
      list-style: none;
      padding-left: 0;
      margin-bottom: 35px;
      text-align: left;
    }

    ul li {
      font-size: 1.15rem;
      margin: 12px 0;
      padding-left: 28px;
      position: relative;
      line-height: 1.4;
      color: #444;
      font-weight: 600;
    }

    ul li::before {
      content: '✔️';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      color: #28a745;
      font-size: 1.2rem;
    }

    .status-pending {
      display: inline-block;
      background-color: #ffc107;
      color: #212529;
      padding: 12px 32px;
      border-radius: 40px;
      font-weight: 700;
      margin-bottom: 30px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      box-shadow: 0 4px 12px rgba(255, 193, 7, 0.6);
      transition: background-color 0.3s ease;
    }

    .status-pending:hover {
      background-color: #e0a800;
    }

    .payment-instruction {
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
      padding: 20px 25px;
      border-radius: 12px;
      margin-bottom: 35px;
      font-size: 1.1rem;
      line-height: 1.5;
      text-align: left;
      box-shadow: 0 3px 8px rgba(255, 243, 204, 0.6);
    }

    a.button, a.pay-button {
      display: inline-block;
      padding: 15px 38px;
      border-radius: 50px;
      font-weight: 700;
      text-decoration: none;
      font-size: 1.15rem;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
      transition: all 0.3s ease;
      text-transform: uppercase;
      cursor: pointer;
      user-select: none;
      margin-top: 10px;
    }

    a.button {
      background-color: #28a745;
      color: white;
      margin-left: 10px;
    }
    a.button:hover {
      background-color: #218838;
      box-shadow: 0 10px 30px rgba(33, 136, 56, 0.4);
      transform: translateY(-3px);
    }

    a.pay-button {
      background-color: #007bff;
      color: white;
      margin-right: 10px;
    }
    a.pay-button:hover {
      background-color: #0056b3;
      box-shadow: 0 10px 30px rgba(0, 86, 179, 0.4);
      transform: translateY(-3px);
    }

    /* Responsive */
    @media (max-width: 640px) {
      .container {
        padding: 30px 20px;
      }

      h2 {
        font-size: 1.8rem;
      }

      ul li {
        font-size: 1rem;
      }

      .payment-instruction {
        font-size: 1rem;
      }

      a.button, a.pay-button {
        padding: 12px 28px;
        font-size: 1rem;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
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
        <li><strong>Tanggal:</strong> {{ $pesanan->tanggal }}</li>
      </ul>

      <div class="status-pending" aria-live="polite">Status: Pending Pembayaran</div>

      <div class="payment-instruction" role="alert">
        Silakan selesaikan pembayaran Anda untuk memproses pesanan.<br />
        Anda dapat melakukan pembayaran melalui metode yang tersedia di halaman pembayaran.
      </div>

      <a href="{{ route('user.bayar', ['id' => $pesanan->id]) }}" class="pay-button" role="button" aria-label="Bayar Sekarang">Bayar</a>
      <a href="{{ route('user.daftarpesanan') }}" class="button" role="button" aria-label="Daftar Pesanan Kamu">Daftar Pesanan Kamu</a>

    @else
      <p>Pesanan tidak ditemukan!</p>
      <a href="{{ route('user.daftarpesanan') }}" class="button" role="button" aria-label="Daftar Pesanan Kamu">Daftar Pesanan Kamu</a>
    @endisset
  </div>

</body>
</html>
