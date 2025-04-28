<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard User</title>
  <style>
    :root {
      --primary: #2d8cff;
      --secondary: #f5f7fa;
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
      background-color: var(--secondary);
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
      max-width: 960px;
      margin: 30px auto;
      padding: 20px;
    }

    .card {
      background-color: white;
      border-radius: 10px;
      padding: 25px 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.04);
      margin-bottom: 20px;
    }

    h1, h3 {
      margin-bottom: 15px;
    }

    p, li {
      font-size: 16px;
      color: var(--text-light);
      line-height: 1.6;
    }

    ul {
      list-style: none;
      padding-left: 0;
    }

    li::before {
      content: "✔️";
      margin-right: 10px;
      color: var(--primary);
    }

    .button-container {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .action-btn {
      background-color: var(--primary);
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 500;
      text-decoration: none;
      transition: 0.2s;
    }

    .action-btn:hover {
      background-color: #1b6edc;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>Halo, {{ auth()->user()->name }}</h2>
    <form class="logout-form" method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <div class="content">
    <div class="card">
      <h1>Selamat Datang 👋</h1>
      <p>Hai <strong>{{ auth()->user()->name }}</strong>! Kamu berhasil login. Gunakan menu berikut untuk mengelola akunmu.</p>
    </div>



    <div class="button-container">
      <a href="{{ route('user.profile') }}" class="action-btn">Profil</a>
      <a href="{{ route('user.buatpesanan') }}" class="action-btn">Buat Pesanan</a>
      <a href="{{ route('user.daftarpesanan') }}" class="action-btn">Daftar Pesanan</a>
    </div>
  </div>

</body>
</html>
