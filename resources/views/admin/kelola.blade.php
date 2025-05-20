<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pesanan</title>
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
      max-width: 1000px;
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

    select, button, input[type="text"] {
      padding: 8px;
      margin-top: 4px;
      font-size: 14px;
    }

    .filter-form {
      margin-bottom: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .back-link {
      display: block;
      margin: 30px auto;
      width: fit-content;
      text-decoration: none;
      color: #3498db;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>Kelola Pesanan</div>
  </div>

  <div class="content">
    <div class="card">
      <h1>Daftar Pesanan</h1>

      <!-- Form Pencarian dan Filter -->
      <form method="GET" action="{{ route('admin.pesanan.index') }}" class="filter-form">
        <input type="text" name="search" placeholder="Cari nama pelanggan..." value="{{ request('search') }}">
        <select name="layanan">
          <option value="">Semua Layanan</option>
          <option value="Cuci Kering" {{ request('layanan') == 'Cuci Kering' ? 'selected' : '' }}>Cuci Kering</option>
          <option value="Cuci Basah" {{ request('layanan') == 'Cuci Basah' ? 'selected' : '' }}>Cuci Basah</option>
          <option value="Setrika" {{ request('layanan') == 'Setrika' ? 'selected' : '' }}>Setrika</option>
          <option value="Lengkap (Cuci + Setrika)" {{ request('layanan') == 'Lengkap (Cuci + Setrika)' ? 'selected' : '' }}>Lengkap (Cuci + Setrika)</option>
        </select>
        <button type="submit">Cari</button>
      </form>

      <!-- Tabel Daftar Pesanan -->
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>No Pesanan</th>
            <th>Berat</th>
            <th>Jenis Layanan</th>
            <th>Paket</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pesanans as $pesanan)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $pesanan->nama_pelanggan }}</td>
              <td>#{{ $pesanan->id }}</td>
              <td>{{ $pesanan->berat ?? '3 kg' }}</td>
              <td>{{ $pesanan->layanan }}</td>
              <td>{{ $pesanan->paket ?? 'Laundry Express' }}</td>
              <td>
                <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <select name="status">
                    <option value="dicuci" {{ $pesanan->status == 'dicuci' ? 'selected' : '' }}>Dicuci</option>
                    <option value="dijemur" {{ $pesanan->status == 'dijemur' ? 'selected' : '' }}>Dijemur</option>
                    <option value="disetrika" {{ $pesanan->status == 'disetrika' ? 'selected' : '' }}>Disetrika</option>
                    <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                  </select>
              </td>
              <td>
                  <button type="submit">Ubah Status</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="text-align: center;">Tidak ada data pesanan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
</body>
</html>
