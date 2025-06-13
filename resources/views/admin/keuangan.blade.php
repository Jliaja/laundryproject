<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Keuangan</title>
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

    h1, h2 {
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
      font-family: Arial, sans-serif;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #4ac6e8;
      color: white;
    }

    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .filter-form {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
      gap: 15px;
      flex-wrap: wrap;
    }

    .filter-form select, .filter-form input, .filter-form button {
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .filter-form button {
      background-color: #4ac6e8;
      color: white;
      border: none;
      cursor: pointer;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #4ac6e8;
      font-weight: bold;
    }

    @media screen and (max-width: 768px) {
      .filter-form {
        flex-direction: column;
      }

      .filter-form > div,
      .filter-form select,
      .filter-form input,
      .filter-form button {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>Kelola Keuangan</div>
  </div>

  <div class="content">
    <div class="card">
      <h1>Laporan Keuangan</h1>

      <!-- Filter Form -->
      <form class="filter-form" method="GET" action="{{ route('admin.keuangan') }}">
        <div>
          <label for="filter">Lihat Berdasarkan:</label><br>
          <select name="filter" id="filter">
            <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahunan</option>
          </select>
        </div>

        <div>
          <label for="tanggal">Pilih Bulan/Tahun:</label><br>
          <div id="filter-options">
            <div id="bulan-dropdown" style="{{ request('filter') == 'bulan' ? '' : 'display:none' }}">
              <select name="bulan" id="bulan">
                @foreach (range(1, 12) as $bln)
                  @php $value = str_pad($bln, 2, '0', STR_PAD_LEFT); @endphp
                  <option value="{{ $value }}" {{ request('bulan') == $value ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $bln)->format('F') }}
                  </option>
                @endforeach
              </select>
            </div>

            <div id="tahun-dropdown" style="{{ request('filter') == 'tahun' ? '' : 'display:none' }}">
              <select name="tahun" id="tahun">
                @for ($year = 2023; $year <= \Carbon\Carbon::now()->year; $year++)
                  <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
              </select>
            </div>
          </div>
        </div>

        <div style="flex: 1;">
          <label for="search">Cari Nama Pembeli:</label><br>
          <input type="text" name="search" id="search" placeholder="Masukkan nama" value="{{ request('search') }}">
        </div>

        <div style="align-self: end;">
          <button type="submit">Tampilkan</button>
        </div>
      </form>

      <!-- Tabel Dinamis (Blade Laravel) -->
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Total Transaksi</th>
            <th>Status Pembayaran</th>
            <tbody>
          <tr><td>1</td><td>A_Fauzi</td><td>Rp 72.000</td><td>Selesai</td></tr>
          <tr><td>2</td><td>Ahmad_KLL@</td><td>Rp 40.000</td><td>Selesai</td></tr>
          <tr><td>3</td><td>"_*Aisyah</td><td>Rp 55.000</td><td>Selesai</td></tr>
          <tr><td>4</td><td>_@Maulana</td><td>Rp 90.000</td><td>Selesai</td></tr>
          <tr><td>5</td><td>$_Rahma</td><td>Rp 30.000</td><td>Selesai</td></tr>
          <tr><td>6</td><td>D_@Kartika</td><td>Rp 120.000</td><td>Selesai</td></tr>
        </tbody>
          </tr>
        </thead>
        <tbody>
          @forelse ($transactions as $transaction)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $transaction->nama_pelanggan }}</td>
              <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
              <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4">Tidak ada data transaksi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

    
      <!-- Total Pemasukan -->
      <div style="margin-top: 20px;">
        <h3>Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
      </div>
    </div>

    <a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
  </div>

  <script>
    document.getElementById('filter').addEventListener('change', function() {
      let filter = this.value;
      document.getElementById('bulan-dropdown').style.display = filter === 'bulan' ? '' : 'none';
      document.getElementById('tahun-dropdown').style.display = filter === 'tahun' ? '' : 'none';
    });
  </script>

</body>
</html>
