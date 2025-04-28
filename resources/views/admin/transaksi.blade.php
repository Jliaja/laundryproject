<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Transaksi</title>
  <style>
    /* Tambahkan gaya yang diinginkan di sini */
    body {
      background: #f1f5f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .navbar div {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .content {
      padding: 40px 20px;
      max-width: 900px;
      margin: auto;
    }

    h1 {
      color: #2c3e50;
      margin-bottom: 20px;
    }

    .card {
      background-color: #ffffffd9;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
    }

    th {
      background-color: #4ac6e8;
      color: white;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>Kelola Transaksi</div>
  </div>

  <div class="content">
    <div class="card">
      <h1>Riwayat Transaksi</h1>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Total Transaksi</th>
            <th>Status Pembayaran</th>
            
          </tr>
        </thead>
        <tbody>
          <!-- Loop untuk menampilkan transaksi -->
          <tr>
            <td>1</td>
            <td>John Doe</td>
            <td>Rp 200.000</td>
            <td>Lunas</td>
            
          </tr>
          <tr>
            <td>2</td>
            <td>Jane Smith</td>
            <td>Rp 150.000</td>
            <td>Belum Lunas</td>
            
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
