<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Harga Pesanan</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #f5f7fa, #c3cfe2);
      margin: 0;
      padding: 40px;
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      max-width: 700px;
      margin: auto;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 16px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #ecf0f1;
      color: #2c3e50;
    }

    .btn {
      background-color: #3498db;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #2980b9;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #7f8c8d;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
      background-color: #fff;
      margin: 15% auto;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    .modal label {
      display: block;
      margin-top: 10px;
    }

    .modal input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .modal button {
      margin-top: 15px;
      background-color: #2ecc71;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .modal button:hover {
      background-color: #27ae60;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Kelola Harga Pesanan</h2>

  <table>
    <thead>
      <tr>
        <th>Jenis Layanan</th>
        <th>Harga per Kg</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Cuci Kering</td>
        <td id="harga-0">Rp 8.000</td>
        <td><button class="btn" onclick="openModal(0, 'Cuci Kering', 8000)">Edit</button></td>
      </tr>
      <tr>
        <td>Cuci Setrika</td>
        <td id="harga-1">Rp 10.000</td>
        <td><button class="btn" onclick="openModal(1, 'Cuci Setrika', 10000)">Edit</button></td>
      </tr>
      <tr>
        <td>Setrika</td>
        <td id="harga-2">Rp 7.000</td>
        <td><button class="btn" onclick="openModal(2, 'Setrika', 7000)">Edit</button></td>
      </tr>
      <tr>
        <td>Lengkap (Cuci + Setrika)</td>
        <td id="harga-3">Rp 12.000</td>
        <td><button class="btn" onclick="openModal(3, 'Lengkap (Cuci + Setrika)', 12000)">Edit</button></td>
      </tr>
    </tbody>
  </table>

  <a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
</div>

<!-- Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Edit Harga</h3>
    <form onsubmit="saveHarga(event)">
      <label for="jenis">Jenis Layanan:</label>
      <input type="text" id="jenis" name="jenis" readonly>

      <label for="harga">Harga per Kg:</label>
      <input type="number" id="harga" name="harga" required>

      <input type="hidden" id="rowIndex">

      <button type="submit">Simpan</button>
    </form>
  </div>
</div>

<script>
  function openModal(index, jenis, harga) {
    document.getElementById('editModal').style.display = 'block';
    document.getElementById('jenis').value = jenis;
    document.getElementById('harga').value = harga;
    document.getElementById('rowIndex').value = index;
  }

  function closeModal() {
    document.getElementById('editModal').style.display = 'none';
  }

  function saveHarga(event) {
    event.preventDefault();
    const index = document.getElementById('rowIndex').value;
    const hargaBaru = document.getElementById('harga').value;
    document.getElementById('harga-' + index).innerText = 'Rp ' + parseInt(hargaBaru).toLocaleString('id-ID');
    closeModal();
  }

  // Menutup modal jika klik di luar modal
  window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
      closeModal();
    }
  };
</script>

</body>
</html>
