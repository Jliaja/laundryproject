<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard User</title>
  <style>
    :root {
      --primary: #2d8cff;
      --secondary: #eef3f9;
      --text-dark: #2c3e50;
      --text-light: #6c757d;
      --bg-white: #ffffff;
      --danger: #e74c3c;
      --success: #28a745;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #dce9f9, #f4f8fb);
      color: var(--text-dark);
    }

    .navbar {
      background-color: var(--bg-white);
      padding: 20px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #e0e0e0;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .navbar h2 {
      font-size: 20px;
      font-weight: 600;
    }

    .logout-btn {
      background-color: var(--danger);
      border: none;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: 0.2s ease-in-out;
    }

    .logout-btn:hover {
      background-color: #c0392b;
    }

    .content {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
    }

    .card {
      background-color: white;
      border-radius: 12px;
      padding: 35px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.05);
      margin-bottom: 30px;
      text-align: center;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    h1 {
      font-size: 28px;
      margin-bottom: 10px;
      color: var(--primary);
    }

    p {
      font-size: 17px;
      color: var(--text-light);
      line-height: 1.6;
    }

    .button-container {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .action-btn {
      background-color: var(--primary);
      color: white;
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: 500;
      font-size: 16px;
      text-decoration: none;
      transition: background 0.2s ease-in-out, transform 0.2s;
    }

    .action-btn:hover {
      background-color: #1a6ed0;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>Halo, {{ auth()->user()->username }}</h2>
    <form class="logout-form" method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <div class="content">
    <div class="card">
      <h1>Selamat Datang 👋</h1>
      <p>Hai <strong>{{ auth()->user()->username }}</strong>! Kamu berhasil login ke aplikasi. Silakan gunakan menu di bawah untuk mulai mengelola akun atau pesananmu.</p>
    </div>

    <div class="button-container">
      <a href="{{ route('user.profile') }}" class="action-btn">Profil</a>
      <a href="{{ route('user.buatpesanan') }}" class="action-btn">Buat Pesanan</a>
      <a href="{{ route('user.daftarpesanan') }}" class="action-btn">Daftar Pesanan</a>
    </div>
  </div>

</body>
</html>
