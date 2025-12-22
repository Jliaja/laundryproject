<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Harga Pesanan</title>

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)),
                  url('/storage/images/backgroudlandry.jpeg') center / cover fixed;
      padding: 40px;
    }

    .container {
      background: #ffffff;
      padding: 30px;
      border-radius: 14px;
      max-width: 850px;
      margin: auto;
      box-shadow: 0 10px 30px rgba(0,0,0,.12);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      overflow: hidden;
      border-radius: 10px;
    }

    thead {
      background: #3498db;
      color: #fff;
    }

    th, td {
      padding: 14px 16px;
    }

    th {
      text-align: left;
      font-size: 14px;
      letter-spacing: .5px;
    }

    tbody tr {
      border-bottom: 1px solid #eee;
      transition: background .2s;
    }

    tbody tr:hover {
      background: #f8f9fa;
    }

    td:last-child {
      text-align: center;
      white-space: nowrap;
    }

    .harga {
      text-align: right;
      font-weight: 600;
      color: #2c3e50;
    }

    .btn-edit {
      background: #f1c40f;
      color: #000;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      margin-right: 6px;
    }

    .btn-edit:hover {
      background: #d4ac0d;
    }

    .btn-delete {
      background: #e74c3c;
      color: #fff;
      padding: 6px 12px;
      border-radius: 6px;
      border: none;
      font-size: 13px;
      cursor: pointer;
    }

    .btn-delete:hover {
      background: #c0392b;
    }

    .footer-action {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 25px;
    }

    .btn-save {
      background: #2ecc71;
      color: #fff;
      padding: 10px 22px;
      border-radius: 8px;
      border: none;
      font-size: 15px;
      cursor: pointer;
    }

    .btn-save:hover {
      background: #27ae60;
    }

    .back-link {
      color: #7f8c8d;
      text-decoration: none;
      font-size: 14px;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      body { padding: 15px; }
      th, td { font-size: 13px; }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Kelola Harga Pesanan</h2>
<form method="POST" action="{{ route('admin.harga.store') }}" style="margin-bottom:20px; display:flex; gap:10px">
  @csrf
  <input type="text" name="layanan" placeholder="Jenis layanan" required style="flex:2;padding:8px">
  <input type="number" name="hargaPerKg" placeholder="Harga / Kg" required style="flex:1;padding:8px">
  <button class="btn-save">➕ Tambah</button>
</form>

  <table>
    <thead>
      <tr>
        <th>Jenis Layanan</th>
        <th style="text-align:right">Harga / Kg</th>
        <th style="text-align:center">Aksi</th>
      </tr>
    </thead>

    <tbody>
@foreach ($hargas as $harga)
<tr>
  <td>{{ $harga->layanan }}</td>

  <td class="harga">
    <form method="POST" action="{{ route('admin.harga.update', $harga->id) }}" style="display:flex; gap:5px; justify-content:flex-end">
      @csrf
      @method('PUT')
      <input type="number" name="hargaPerKg"
             value="{{ $harga->hargaPerKg }}"
             style="width:120px;padding:5px">
      <button class="btn-edit">💾</button>
    </form>
  </td>

  <td>
    <form action="{{ route('admin.harga.destroy', $harga->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <button class="btn-delete" onclick="return confirm('Hapus harga?')">🗑️</button>
    </form>
  </td>
</tr>
@endforeach
</tbody>

  </table>

  <div class="footer-action">
    <a href="{{ route('admin.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
  </div>
</div>

</body>
</html>
