<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background-image: url('{{ asset('image/laundry.png') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      font-family: sans-serif;
    }

    .navbar {
      background-color: #ffffffcc; /* sedikit transparan */
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-bottom: 1px solid #eaeaea;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .navbar div {
      font-size: 20px;
      font-weight: 600;
      color: #34495e;
    }

    .logout-form {
      display: inline;
    }

    .logout-btn {
      background-color: #e74c3c;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .logout-btn:hover {
      background-color: #c0392b;
    }

    .content {
      padding: 40px 20px;
      max-width: 960px;
      margin: auto;
    }

    .card {
      background-color: #ffffffcc; /* transparan agar menyatu dengan background */
      border-radius: 16px;
      padding: 35px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      margin-bottom: 30px;
      transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }

    h1, h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }

    p {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
    }

    ul {
      padding-left: 20px;
      list-style: none;
    }

    li {
      margin-bottom: 10px;
      font-size: 16px;
      position: relative;
      padding-left: 25px;
      color: #444;
    }

    li::before {
      content: '✔️';
      position: absolute;
      left: 0;
      top: 1px;
    }

    .button-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 30px;
    }

    .action-btn {
      background-color: #3498db;
      color: white;
      padding: 12px 24px;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      min-width: 180px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .action-btn:hover {
      background-color: #2980b9;
      transform: translateY(-2px);
    }

    @media (max-width: 600px) {
      .button-container {
        flex-direction: column;
        align-items: center;
      }

      .action-btn {
        width: 100%;
        text-align: center;
      }
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

    <div class="button-container">
      <a href="{{ route('admin.kelola') }}" class="action-btn">Kelola Pesanan</a>
      <a href="{{ route('admin.keuangan') }}" class="action-btn">Kelola Keuangan</a>
      <a href="{{ route('admin.harga') }}" class="action-btn">Kelola Harga pesanan</a>
    </div>
  </div>

</body>
</html>
