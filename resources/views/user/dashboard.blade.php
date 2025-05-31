<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard User</title>
   <style>
    :root {
      --primary: #2d8cff;
      
      --text-dark: #2c3e50;
      --text-light: #6c757d;
      --bg-white: #ffffff;
      --danger: #e74c3c;
      --success: #28a745;
      --sidebar-bg: linear-gradient(180deg, #1c92d2 0%, #0066cc 100%);
      --sidebar-text: #fff;
      --sidebar-hover: #166ca5;
      --sidebar-shadow: rgba(0, 0, 0, 0.2);
      --sidebar-border-radius: 12px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* Background image + overlay tetap */
      background: 
        linear-gradient(rgba(220, 233, 249, 0.85), rgba(244, 248, 251, 0.85)),
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: var(--text-dark);
      min-height: 100vh;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background: var(--sidebar-bg);
      color: var(--sidebar-text);
      display: flex;
      flex-direction: column;
      padding: 30px 20px;
      gap: 25px;
      box-shadow: 3px 0 12px var(--sidebar-shadow);
      border-top-right-radius: var(--sidebar-border-radius);
      border-bottom-right-radius: var(--sidebar-border-radius);
      flex-shrink: 0;
      position: relative;
      z-index: 5;
      transition: background 0.3s ease;
      .logout-form {
  position: absolute;
  bottom: 30px;   /* jarak dari bawah sidebar */
  left: 20px;     /* jarak dari kiri sidebar (padding sidebar) */
  width: calc(100% - 40px); /* full lebar sidebar minus padding kiri + kanan */
}

.logout-btn {
  background-color: var(--danger);
  border: none;
  color: white;
  padding: 10px 16px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
  width: 100%;
  font-size: 16px;
}

.logout-btn:hover {
  background-color: #c0392b;
}
    }

    .sidebar:hover {
      background: linear-gradient(180deg, #1e9ef7 0%, #005dbb 100%);
      box-shadow: 4px 0 18px rgba(0, 0, 0, 0.35);
    }

    .sidebar h2 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 40px;
      text-align: center;
      letter-spacing: 1.5px;
      text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--sidebar-text);
      text-decoration: none;
      font-size: 17px;
      padding: 12px 15px;
      border-radius: 10px;
      transition: background-color 0.3s, transform 0.2s ease;
      font-weight: 600;
      box-shadow: inset 0 0 0 0 var(--sidebar-text);
      position: relative;
    }

    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background: transparent;
      border-radius: 10px 0 0 10px;
      transition: background 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: var(--sidebar-hover);
      transform: translateX(6px);
      box-shadow: inset 4px 0 10px rgba(255, 255, 255, 0.3);
    }

    .sidebar a.active::before {
      background: var(--primary);
    }

    /* Icon style (emoji or SVG) */
    .sidebar a .icon {
      font-size: 22px;
      min-width: 28px;
      text-align: center;
      filter: drop-shadow(0 1px 1px rgba(0,0,0,0.3));
      transition: transform 0.2s ease;
    }

    .sidebar a:hover .icon {
      transform: scale(1.2);
    }

    /* Main content */
    .main-content {
      flex-grow: 1;
      overflow-y: auto;
      padding: 40px 50px;
      background-color: var(--secondary);
    }

    .navbar {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 40px;
      gap: 20px;
    }

    .navbar h2 {
      font-size: 18px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .card {
      background-color: var(--bg-white);
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

  <aside class="sidebar">
    <h2>Menu</h2>
    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
      <span class="icon"></span> Profil
    </a>
    <a href="{{ route('user.buatpesanan') }}" class="{{ request()->routeIs('user.buatpesanan') ? 'active' : '' }}">
      <span class="icon"></span> Buat Pesanan
    </a>
    <a href="{{ route('user.daftarpesanan') }}" class="{{ request()->routeIs('user.daftarpesanan') ? 'active' : '' }}">
      <span class="icon"></span> Daftar Pesanan
    </a>
    <form class="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
  </aside>

  <main class="main-content">
    <div class="navbar">
      
      
    </div>

    <div class="card">
      <h1>Selamat Datang 👋</h1>
      <p>Hai <strong>{{ auth()->user()->username }}</strong>! Kamu berhasil login ke aplikasi. Silakan gunakan menu di sidebar kiri untuk mulai mengelola akun atau pesananmu.</p>
    </div>
  </main>

</body>
</html>
