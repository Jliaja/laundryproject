<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pesanan</title>
  <style>
    body {
      background: url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      margin: 0; padding: 0;
      font-family: Arial, sans-serif;
    }
    .navbar {
      background-color: #fff;
      padding: 15px 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      font-weight: bold;
      font-size: 18px;
      color: #333;
    }
    .content {
      max-width: 1000px;
      margin: 40px auto;
      background-color: #ffffffd9;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #166ca5;
      color: white;
    }
    input[type="text"], select {
      padding: 6px 8px;
      font-size: 14px;
      width: 100%;
      box-sizing: border-box;
    }
    button {
      padding: 10px 20px;
      background-color: #166ca5;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 20px;
    }
    button:hover {
      background-color: #125080;
    }
    .back-link {
  padding: 10px 20px;
      background-color: #166ca5;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 20px;
    
}
  </style>
</head>
<body>

  <div class="navbar">Kelola Pesanan</div>

  <div class="content">
    <h1>Daftar Pesanan</h1>

    <form action="{{ route('admin.pesanan.updateMassal') }}" method="POST">
      @csrf
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>No Pesanan</th>
            <th>Jumlah</th>
            <th>Jenis Layanan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pesanans as $pesanan)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $pesanan->nama_pelanggan }}</td>
              <td>#{{ $pesanan->id }}</td>

              @if($pesanan->status === 'dibatalkan')
                <td colspan="3" style="color: red; text-align: center;">
                  Pesanan dibatalkan oleh user
                </td>
              @else
                <td>
                  <input type="text" name="pesanans[{{ $pesanan->id }}][jumlah]" value="{{ old('pesanans.'.$pesanan->id.'.jumlah', $pesanan->jumlah) }}" />
                </td>
                <td>{{ $pesanan->layanan }}</td>
                <td>
                  <select name="pesanans[{{ $pesanan->id }}][status]">
                    <option value="Pending" {{ $pesanan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="hitung berat dan harga" {{ $pesanan->status == 'hitung berat dan harga' ? 'selected' : '' }}>Hitung berat dan harga</option>
                    <option value="diproses" {{ $pesanan->status == 'proses' ? 'selected' : '' }}>Di Proses</option>
                    <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                  </select>
                </td>
              @endif
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center;">Tidak ada data pesanan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
<a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
      <button type="submit">Update Semua</button>
    </form>

  </div>

</body>

</html>
