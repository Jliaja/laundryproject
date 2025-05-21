<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat Pesanan</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: 
        linear-gradient(rgba(220, 233, 249, 0.85), rgba(244, 248, 251, 0.85)),
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: #2c3e50;
      min-height: 100vh;
      margin: 0;
      padding: 40px;
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }

    select, input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    button {
      margin-top: 25px;
      width: 100%;
      padding: 12px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2980b9;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #7f8c8d;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Form Buat Pesanan</h2>
    <form action="{{ route('user.buatpesanan') }}" method="POST">
      @csrf

      <label for="layanan">Layanan</label>
      <select id="layanan" name="layanan" required>
        <option value="">-- Pilih Layanan --</option>
        @foreach($hargas as $harga)
          <option value="{{ $harga->layanan }}">{{ $harga->layanan }}</option>
        @endforeach
      </select>

      <label for="tanggal">Tanggal</label>
      <input type="date" id="tanggal" name="tanggal" required>

      <button type="submit">Kirim Pesanan</button>
    </form>

    <a class="back-link" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>
  </div>

</body>
</html>
