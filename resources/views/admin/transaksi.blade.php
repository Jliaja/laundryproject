<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Transaksi</title>
  <style>
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

    .filter-form {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .filter-form select, .filter-form input {
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
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

      <!-- Filter Form -->
      <form class="filter-form" method="GET" action="{{ route('admin.transaksi') }}">
        <div>
          <label for="filter">Filter Berdasarkan:</label>
          <select name="filter" id="filter">
            <option value="bulan">Per Bulan</option>
            <option value="minggu">Per Minggu</option>
            <option value="tahun">Per Tahun</option>
          </select>
        </div>

        <div>
          <label for="tanggal">Pilih Tanggal:</label>
          <input type="date" name="tanggal" id="tanggal">
        </div>

        <button type="submit">Terapkan Filter</button>
      </form>

      <!-- Table untuk Menampilkan Riwayat Transaksi -->
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
          @foreach ($transactions as $transaction)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $transaction->nama_pembeli }}</td>
              <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
              <td>{{ $transaction->status_pembayaran }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>

</body>
</html>
