<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password</title>
  <style>
    body {
      background: 
        linear-gradient(rgba(220, 233, 249, 0.85), rgba(244, 248, 251, 0.85)),
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: var(--text-dark);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
    }

    .box {
      background: #ffffffdd;
      padding: 35px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 350px;
      text-align: center;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h3 {
      margin-bottom: 20px;
      color: #2c3e50;
    }

    input[type="email"] {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border: none;
      border-radius: 12px;
      background-color: #f2f9fc;
      font-size: 15px;
      font-style: italic;
      font-weight: bold;
      box-sizing: border-box;
      text-align: center;
      transition: all 0.3s ease;
    }

    input[type="email"]:focus {
      outline: none;
      background-color: #ffffff;
      box-shadow: 0 0 8px rgba(74, 198, 232, 0.3);
    }

    button {
      width: 100%;
      padding: 12px;
      background: #2d8cff;
      color: #fff;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      margin-top: 10px;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #1a2935;
    }

    .message {
      margin-top: 15px;
      font-size: 14px;
      background: #ffecec;
      padding: 10px;
      border-radius: 8px;
      color: red;
    }

    .success {
      background: #e3ffe8;
      color: green;
    }
  </style>
</head>
<body>
  <form class="box" method="POST" action="{{ route('verifikasi.kirim.kode') }}">
    @csrf
    <h3>Lupa Password</h3>
    <p>Masukkan email akun Anda dan kami akan mengirimkan kode verifikasi untuk reset password.</p>
    
    <input type="email" name="email" placeholder="Masukkan Email Anda" required>
    <button type="submit">Kirim</button>

    {{-- Pesan Error --}}
    @if(session('error'))
      <div class="message">{{ session('error') }}</div>
    @endif

    {{-- Pesan Sukses --}}
    @if(session('pesan'))
      <div class="message success">{{ session('pesan') }}</div>
    @endif

    {{-- Validasi Error --}}
    @if ($errors->any())
      <div class="message">
        <ul style="margin: 0; padding-left: 20px; text-align: left;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </form>
</body>
</html>
