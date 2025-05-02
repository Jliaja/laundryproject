<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pesanan</title>
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
    <div>Kelola Pesanan</div>
  </div>

  <div class="content">
    <div class="card">
      <h1>Daftar Pesanan</h1>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Status Pesanan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Loop untuk menampilkan pesanan -->
          @foreach($pesanans as $pesanan)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $pesanan->nama_pelanggan }}</td>
    <td>{{ $pesanan->status }}</td>
    <td>
      <!-- Form untuk update status pesanan -->
      <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="proses" {{ $pesanan->status == 'proses' ? 'selected' : '' }}>Proses</option>
            <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="batal" {{ $pesanan->status == 'batal' ? 'selected' : '' }}>Batal</option>
        </select>
        
        <button type="submit">Ubah Status</button>
    </form>
    
    </td>
  </tr>
@endforeach

        </tbody>
      </table>
    </div>
  </div>
  <a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
</body>
</html>
