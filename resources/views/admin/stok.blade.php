<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Stok Laundry</title>

  <style>
    body {
      background: url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .content {
      max-width: 1000px;
      margin: 40px auto;
      background-color: #ffffffd9;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    /* ===== STOK LAUNDRY ===== */
    .card {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .card h1 {
      font-size: 26px;
      font-weight: 700;
      color: #2563eb;
      margin-bottom: 25px;
    }

    .stok-form {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 15px;
      margin-bottom: 30px;
    }

    .stok-form input {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .stok-form button {
      grid-column: span 2;
      background-color: #4ac6e8;
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th {
      background: #4ac6e8;
      color: white;
      padding: 12px;
    }

    td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }

    .stok-warning {
      background: #ffe6e6;
      font-weight: bold;
    }

    .btn-hapus {
      background: #e74c3c;
      color: white;
      border: none;
      padding: 7px 14px;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>

<body>

<div class="content">
  <div class="card">
    <h1>Stok Laundry 🧴</h1>

    <form class="stok-form" method="POST" action="{{ route('admin.stok.store') }}">
      @csrf
      <input type="text" name="nama_barang" placeholder="Nama Barang" required>
      <input type="text" name="kategori" placeholder="Kategori" required>
      <input type="number" name="stok" placeholder="Jumlah Stok" required>
      <input type="text" name="satuan" placeholder="Satuan (kg / liter / pcs)" required>
      <button type="submit">Tambah Stok</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Satuan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($stok as $s)
        <tr class="{{ $s->stok <= ($s->stok_minimum ?? 5) ? 'stok-warning' : '' }}">
          <td>{{ $s->nama_barang }}</td>
          <td>{{ $s->kategori }}</td>
          <td>{{ $s->stok }}</td>
          <td>{{ $s->satuan }}</td>
          <td>
            <form method="POST" action="{{ route('admin.stok.destroy',$s->id) }}">
              @csrf
              @method('DELETE')
              <button class="btn-hapus">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>

</body>
</html>
