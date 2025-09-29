<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Laundry Express</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background:
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: #333;
      line-height: 1.6;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    header {
      text-align: center;
      padding: 100px 20px 60px;
    }

    header h1 {
      font-size: 40px;
      color: #1c92d2;
      background: #fff;
      display: inline-block;
      padding: 12px 30px;
      border-radius: 30px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    header p {
      margin-top: 20px;
      font-size: 18px;
      background: #fff;
      display: inline-block;
      padding: 10px 24px;
      border-radius: 25px;
      color: #1c92d2;
      font-weight: 500;
    }

    .scroll-button {
      margin-top: 30px;
      display: inline-block;
      background-color: #1c92d2;
      color: #fff;
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .scroll-button:hover {
      background-color: #156eaa;
    }

    .section {
      background: rgba(255, 255, 255, 0.95);
      text-align: center;
      padding: 60px 20px;
      max-width: 1100px;
      margin: 30px auto;
      border-radius: 20px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .section h2 {
      font-size: 28px;
      color: #1c92d2;
      margin-bottom: 20px;
    }

    .features {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      justify-content: center;
    }

    .feature-box {
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      width: 300px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      text-align: left;
    }

    .feature-box h3 {
      color: #1c92d2;
      margin-bottom: 10px;
      font-size: 18px;
    }

    .feature-box p {
      font-size: 14px;
      color: #555;
    }

    .login-section {
      display: flex;
      justify-content: center;
      padding: 80px 20px;
    }

    .login-box {
      background: #fff;
      padding: 40px 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      text-align: center;
    }

    .login-box img {
      width: 90px;
      margin-bottom: 20px;
    }

    .login-box .welcome-text {
      font-size: 16px;
      color: #555;
      margin-bottom: 25px;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      background: #f9f9f9;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .login-box input:focus {
      border-color: #1c92d2;
      background: #fff;
      outline: none;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background-color: #1c92d2;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 15px;
      margin-top: 15px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-box button:hover {
      background-color: #187ab9;
    }

    .login-box .links {
      margin-top: 20px;
      font-size: 13px;
      display: flex;
      justify-content: space-between;
    }

    .login-box .links a {
      color: #1c92d2;
    }

    .login-box .links a:hover {
      text-decoration: underline;
    }

    .message {
      margin-top: 15px;
      font-size: 14px;
    }

    .success {
      color: #28a745;
    }

    .error {
      color: #e74c3c;
    }

    @media (max-width: 768px) {
      .features {
        flex-direction: column;
        align-items: center;
      }

      header h1 {
        font-size: 28px;
      }

      .section h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Selamat Datang di Cemerlang Laundry</h1>
    <p>Layanan cepat, bersih, dan terpercaya untuk aktivitas harian Anda.</p>
    <a href="#login" class="scroll-button">Login Sekarang</a>
  </header>

  <section class="section">
    <h2>Tentang Kami</h2>
    <p>Kami adalah penyedia laundry modern dengan teknologi terkini dan bahan ramah lingkungan untuk hasil terbaik pada pakaian Anda.</p>
  </section>

  <section class="section">
    <h2>Layanan Kami</h2>
    <div class="features">
      <div class="feature-box">
        <h3> Cuci Kering & Setrika</h3>
        <p>Layanan rapi dan cepat dengan hasil wangi dan siap pakai.</p>
      </div>
      <div class="feature-box">
        <h3> Antar-Jemput</h3>
        <p>Tanpa repot keluar rumah, kami antar-jemput pakaian Anda langsung ke lokasi.</p>
      </div>
    </div>
  </section>

  <section class="section">
    <h2>Kenapa Memilih Kami?</h2>
    <div class="features">
      <div class="feature-box">
        <h3> Harga Terjangkau</h3>
        <p>Transparan dan bersaing untuk semua kalangan.</p>
      </div>
      <div class="feature-box">
        <h3> Aman untuk Semua Bahan</h3>
        <p>Kami menangani kain halus, batik, hingga pakaian anak-anak dengan hati-hati.</p>
      </div>
      <div class="feature-box">
        <h3> Layanan Pelanggan</h3>
        <p>Kami siap membantu melalui WhatsApp atau telepon kapan pun Anda butuh.</p>
      </div>
    </div>
  </section>

  <div class="login-section" id="login">
    <form class="login-box" action="{{ route('login.submit') }}" method="POST">
      @csrf

      <img src="{{ asset('storage/images/login.png') }}" alt="Login Icon">
      <div class="welcome-text">Silakan login terlebih dahulu untuk mengakses layanan kami</div>

      <input type="text" name="username" placeholder="USERNAME" value="{{ old('username') }}" required>
      @error('username')
        <div class="error">{{ $message }}</div>
      @enderror

      <input type="password" name="password" placeholder="PASSWORD" required>
      @error('password')
        <div class="error">{{ $message }}</div>
      @enderror

      <button type="submit">LOGIN</button>

      <div class="links">
        <a href="{{ route('kirimemail') }}">Lupa Password?</a>
        <a href="{{ route('register') }}">Daftar</a>
      </div>

      <div class="message">
        @if(session('success'))
          <div class="success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="error">{{ session('error') }}</div>
        @endif
      </div>
    </form>
  </div>

</body>
</html>
