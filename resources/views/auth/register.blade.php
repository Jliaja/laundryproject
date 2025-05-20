<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi</title>
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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .register-box {
      background: #fff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 380px;
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .register-box img {
      width: 60px;
      margin: 0 auto 20px;
      display: block;
    }

    .register-box h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    .register-box label {
      font-weight: bold;
      margin-top: 12px;
      display: block;
      color: #333;
    }

    .register-box input,
    .register-box textarea {
      width: 100%;
      padding: 12px 15px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      background: #f9f9f9;
      box-sizing: border-box;
      transition: border-color 0.3s;
    }

    .register-box input:focus,
    .register-box textarea:focus {
      border-color: #2980b9;
      background: #fff;
      outline: none;
    }

    .register-box button {
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      background-color: #2980b9;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .register-box button:hover {
      background-color: #1c5980;
    }

    .message {
      margin-top: 15px;
      color: red;
      font-size: 14px;
      background: #ffecec;
      padding: 10px;
      border-radius: 8px;
    }

    ul {
      padding-left: 18px;
      margin: 0;
    }
  </style>
</head>
<body>

  <div class="register-box">
    <img src="{{ asset('storage/usericon.jpeg') }}" alt="User Icon">
    <h2>Formulir Registrasi</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <label for="username">Username</label>
      <input type="text" name="username" value="{{ old('username') }}" required>

      <label for="email">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>

      <label for="password">Password</label>
      <input type="password" name="password" required>

      <label for="confirm_password">Konfirmasi Password</label>
      <input type="password" name="confirm_password" required>

      <label for="address">Alamat</label>
      <textarea name="address" rows="3" required>{{ old('address') }}</textarea>

      <button type="submit">Daftar Sekarang</button>
    </form>

    @if ($errors->any())
      <div class="message">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

</body>
</html>
