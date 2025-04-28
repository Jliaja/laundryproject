<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(to right, #4ac6e8, #a1e0f3);
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

    .logout-form {
      display: inline;
    }

    .logout-btn {
      background-color: #e74c3c;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #c0392b;
    }

    .content {
      padding: 40px 20px;
      max-width: 900px;
      margin: auto;
    }

    .card {
      background-color: #ffffffd9;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: scale(1.02);
    }

    h1, h3 {
      margin: 0 0 15px 0;
      color: #2c3e50;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 8px;
      font-size: 16px;
    }

    .emoji {
      margin-right: 6px;
    }

    .button-container {
      display: flex;
      gap: 20px;
      margin-top: 30px;
    }

    .action-btn {
      background-color: #3498db;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .action-btn:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>Halo, Admin 👋</div>
    <form class="logout-form" method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <div class="content">
    <div class="card">
      <h1>Selamat Datang di Dashboard Admin</h1>
      <p>Hai <strong>Admin</strong>! Kamu berhasil login. Di sini kamu bisa mengelola pesanan dan transaksi.</p>
    </div>

    <div class="card">
      <h3>🔧 Fitur yang Tersedia</h3>
      <ul>
        <li><span class="emoji">📊</span> Mengelola Keuangan</li>
        <li><span class="emoji">⚙️</span> Mengelola Pesanan</li>
      </ul>
    </div>

    <!-- Menambahkan tombol navigasi ke halaman Kelola Pesanan dan Kelola Transaksi -->
    <div class="button-container">
      <a href="{{ route('admin.kelola') }}" class="action-btn">Kelola Pesanan</a>
      <a href="{{ route('admin.transaksi') }}" class="action-btn">Kelola Transaksi</a>
    </div>
  </div>

</body>
</html>
