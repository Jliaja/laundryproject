<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Verifikasi Kode</title>
  <style>
    body {
      background-color: #4ac6e8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .verify-box {
      background-color: #d9d9d9;
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
      background-color: #4ac6e8;
      font-style: italic;
      font-weight: bold;
    }

    .verify-box button {
      padding: 10px 20px;
      margin-top: 10px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }

    .message {
      margin-top: 15px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <form class="verify-box" action="{{ route('verifikasi.submit') }}" method="POST">
    @csrf
    <img src="key-icon.png" alt="Key Icon">
    <h3>Masukkan Kode Verifikasi</h3>
    <input type="text" name="kode" placeholder="Kode 6 Digit" required>
    <button type="submit">Verifikasi</button>

    <div class="message">
      {!! $pesan ?? '' !!}
    </div>
  </form>
</body>
</html>
