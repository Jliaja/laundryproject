<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Pesanan Laundry</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #4ac6e8, #a1e0f3);
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 60px auto;
      background-color: #ffffffd9;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    input, textarea {
      padding: 10px;
      margin: 5px 0 15px;
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 16px;
    }

    button {
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }

    .form-btn-delete {
      background-color: #e74c3c;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .form-btn-delete:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Edit Pesanan Laundry</h2>

    <form action="{{ route('order.update', $pesanan->id) }}" method="POST">
      @csrf
      @method('PUT')

      <label for="nama_pelanggan">Nama Pelanggan</label>
      <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="{{ $pesanan->nama_pelanggan }}" required>

      <label for="layanan">Layanan</label>
      <input type="text" id="layanan" name="layanan" value="{{ $pesanan->layanan }}" required>

      <label for="jumlah">Jumlah (Kg)</label>
      <input type="number" id="jumlah" name="jumlah" value="{{ $pesanan->jumlah }}" required>

      <label for="tanggal">Tanggal Pesanan</label>
      <input type="date" id="tanggal" name="tanggal" value="{{ $pesanan->tanggal }}" required>

      <button type="submit">Update Pesanan</button>
    </form>

    <form action="{{ route('order.delete', $pesanan->id) }}" method="POST" style="margin-top: 20px;">
      @csrf
      @method('DELETE')
      <button type="submit" class="form-btn-delete">Hapus Pesanan</button>
    </form>
  </div>

</body>
</html>
