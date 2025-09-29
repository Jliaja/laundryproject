<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Keuangan</title>
  <style>
    body {
  background:
    
    url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
  background-size: cover;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  color: #2c3e50;
}

.navbar {
  background-color: #fff;
  padding: 15px 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  font-size: 22px;
  font-weight: 700;
  color: #2563eb; /* warna biru untuk highlight */
  letter-spacing: 1px;
  text-transform: uppercase;
}

.content {
  padding: 40px 20px;
  max-width: 900px;
  margin: 30px auto;
}

h1, h2 {
  color: #2c3e50;
  margin-bottom: 20px;
  font-weight: 700;
}

.card {
  background-color: #ffffffd9;
  border-radius: 12px;
  padding: 30px 30px 40px 30px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  margin-bottom: 40px;
  transition: box-shadow 0.3s ease;
}

.card:hover {
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin-top: 20px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

th, td {
  padding: 12px 15px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #4ac6e8;
  color: white;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

tbody tr:nth-child(even) {
  background-color: #f9f9f9;
  transition: background-color 0.3s ease;
}

tbody tr:hover {
  background-color: #e0f7ff;
  cursor: pointer;
}

.filter-form {
  display: flex;
  justify-content: flex-start;
  margin-bottom: 30px;
  gap: 20px;
  flex-wrap: wrap;
  align-items: flex-end;
}

.filter-form > div {
  display: flex;
  flex-direction: column;
  min-width: 140px;
}

.filter-form label {
  font-weight: 600;
  margin-bottom: 6px;
  color: #333;
}

.filter-form select, .filter-form input {
  padding: 8px 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.3s ease;
}

.filter-form select:focus, .filter-form input:focus {
  border-color: #4ac6e8;
  outline: none;
}

.filter-form button {
  background-color: #4ac6e8;
  color: white;
  border: none;
  padding: 10px 20px;
  font-weight: 700;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.filter-form button:hover {
  background-color: #3a9bdc;
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
    align-items: stretch;
  }
  .filter-form > div, .filter-form select, .filter-form input, .filter-form button {
    width: 100%;
  }
}

/* Grid untuk statistik */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
  max-width: 900px;
  margin-left: auto;
  margin-right: auto;
}

.text-2xl {
  font-size: 1.5rem;
}

.font-bold {
  font-weight: bold;
}

.text-blue-600 {
  color: #2563eb;
}

.text-green-600 {
  color: #16a34a;
}

.text-purple-600 {
  color: #7c3aed;
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
<main class="content">
    <div class="grid mb-4">
      <div class="card">
        <h2>Pesanan Bulan Ini</h2>
        <p class="text-2xl font-bold text-blue-600">{{ $ordersThisMonth }}</p>
      </div>
      <div class="card">
        <h2>Pendapatan Bulan Ini</h2>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</p>
      </div>
      <div class="card">
        <h2>Pendapatan Tahun Ini</h2>
        <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($incomeThisYear, 0, ',', '.') }}</p>
      </div>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px; max-width: 900px; margin: auto;">
      <div class="card" style="max-height: 300px; padding: 10px;">
        <canvas id="ordersChart"></canvas>
      </div>
      <div class="card" style="max-height: 300px; padding: 10px;">
        <canvas id="incomeChart"></canvas>
      </div>
    </div>
  </main>
      @if ($errors->any())
        <div style="color: red; font-weight: bold; margin-bottom: 20px;">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form class="filter-form" method="GET" action="{{ route('admin.keuangan') }}">
        <div>
          <label for="filter">Lihat Berdasarkan:</label><br>
          <select name="filter" id="filter">
            <option value="bulan" {{ (isset($filter) && $filter == 'bulan') ? 'selected' : '' }}>Bulanan</option>
            <option value="tahun" {{ (isset($filter) && $filter == 'tahun') ? 'selected' : '' }}>Tahunan</option>
          </select>
        </div>

        <div id="bulan-dropdown" style="{{ (isset($filter) && $filter == 'bulan') ? '' : 'display:none' }}">
          <label for="bulan">Bulan:</label><br>
          <select name="bulan" id="bulan">
            @foreach (range(1, 12) as $bln)
              @php $val = str_pad($bln, 2, '0', STR_PAD_LEFT); @endphp
              <option value="{{ $val }}" {{ (isset($bulan) && $bulan == $val) ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create(null, $bln)->format('F') }}
              </option>
            @endforeach
          </select>
        </div>

        <div id="tahun-dropdown">
          <label for="tahun">Tahun:</label><br>
          <select name="tahun" id="tahun">
            @for ($y = 2023; $y <= now()->year; $y++)
              <option value="{{ $y }}" {{ (isset($tahun) && $tahun == $y) ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
          </select>
        </div>

        <div style="align-self: end;">
          <button type="submit">Tampilkan</button>
        </div>
      </form>

      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Tanggal Pesanan</th>
            <th>Total Transaksi</th>
            <th>Status Pembayaran</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($transactions as $transaction)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $transaction->nama_pelanggan }}</td>
              <td>{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d-m-Y') }}</td>
              <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
              <td>{{ ucfirst($transaction->status_pembayaran) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Tidak ada data transaksi.</td>
            </tr>
          @endforelse
        </tbody>
        
      </table>


      <div style="margin-top: 20px;">
        <h3>Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
      </div>
      <a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
    </div>
    
  </div>

  <script>
    document.getElementById('filter').addEventListener('change', function () {
      const filter = this.value;
      document.getElementById('bulan-dropdown').style.display = filter === 'bulan' ? '' : 'none';
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const labels = @json($chartLabels);
    const ordersData = @json($ordersData);
    const incomeData = @json($incomeData);

    const ctxOrders = document.getElementById('ordersChart').getContext('2d');
    const gradientOrders = ctxOrders.createLinearGradient(0, 0, 0, 200);
    gradientOrders.addColorStop(0, 'rgba(0, 123, 255, 0.5)');
    gradientOrders.addColorStop(1, 'rgba(0, 123, 255, 0)');

    new Chart(ctxOrders, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah Pesanan',
          data: ordersData,
          borderColor: '#007bff',
          backgroundColor: gradientOrders,
          tension: 0.4,
          fill: true,
          pointRadius: 3,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
      }
    });

    const ctxIncome = document.getElementById('incomeChart').getContext('2d');
    const gradientIncome = ctxIncome.createLinearGradient(0, 0, 0, 200);
    gradientIncome.addColorStop(0, 'rgba(40, 167, 69, 0.5)');
    gradientIncome.addColorStop(1, 'rgba(40, 167, 69, 0)');

    new Chart(ctxIncome, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Pendapatan',
          data: incomeData,
          borderColor: '#28a745',
          backgroundColor: gradientIncome,
          tension: 0.4,
          fill: true,
          pointRadius: 3,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>

</body>
</html>
