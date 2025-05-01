<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat Pesanan</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #f5f7fa, #c3cfe2);
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
      color: #2c3e50;
      margin-bottom: 25px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
      color: #34495e;
    }

    input, select {
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

    .total-price {
      font-size: 18px;
      font-weight: bold;
      color: #27ae60;
      margin-top: 20px;
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
          <option value="Cuci Kering" data-harga="5000">Cuci Kering</option>
          <option value="Cuci Basah" data-harga="6000">Cuci Basah</option>
          <option value="Setrika" data-harga="4000">Setrika</option>
          <option value="Lengkap (Cuci + Setrika)" data-harga="8000">Lengkap (Cuci + Setrika)</option>
        </select>
      
        <label for="jumlah">Jumlah (kg)</label>
        <input type="number" id="jumlah" name="jumlah" min="1" step="0.1" required>
      
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" required>
        
        <div class="total-price">
          Total Harga: Rp <span id="total-harga">0</span>
        </div>
      
        <button type="submit">Kirim Pesanan</button>
      </form>
      


    <a class="back-link" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>
  </div>

  <script>
    // Update harga total saat memilih layanan atau jumlah kg
    document.getElementById('layanan').addEventListener('change', updateTotal);
    document.getElementById('jumlah').addEventListener('input', updateTotal);

    function updateTotal() {
      var layanan = document.getElementById('layanan');
      var jumlah = document.getElementById('jumlah').value;
      var hargaPerKg = layanan.options[layanan.selectedIndex].getAttribute('data-harga');
      
      if (jumlah && hargaPerKg) {
        var total = hargaPerKg * jumlah;
        document.getElementById('total-harga').textContent = total.toLocaleString();
      }
    }
  </script>

</body>
</html>
