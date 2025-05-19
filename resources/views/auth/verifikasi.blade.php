<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Verifikasi Kode</title>
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
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .verify-box {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      width: 300px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
    }

    .verify-box img {
      width: 40px;
      margin-bottom: 15px;
    }

    .verify-box input[type="text"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      background-color: #ffffff;
      font-style: italic;
      font-weight: bold;
    }

    .verify-box button {
      padding: 10px 20px;
      margin-top: 10px;
      background-color: #2d8cff;
      color: #fff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }

    .message {
      margin-top: 15px;
      font-size: 14px;
      padding: 10px;
      border-radius: 8px;
    }

    .success {
      background: #e3ffe8;
      color: green;
    }

    .error-message {
      background: #ffecec;
      color: red;
    }
  </style>
</head>
<body>
  <form class="verify-box" action="{{ route('verifikasi.kode') }}" method="POST">
    @csrf
    <h3>Masukkan Kode Verifikasi</h3>
    <input type="text" name="kode" placeholder="Kode 5 Digit" required>
    <button type="submit">Verifikasi</button>

    {{-- Pesan Session --}}
    @if(session('pesan'))
      <div class="message success">{{ session('pesan') }}</div>
    @endif

    @if(session('error'))
      <div class="message error-message">{{ session('error') }}</div>
    @endif
  </form>
</body>
</html>
