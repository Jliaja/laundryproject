<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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

    .login-box {
  background: #ffffff;
  padding: 40px 30px;
  border-radius: 14px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  text-align: left; /* supaya input gak ketarik ke tengah */
  width: 350px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

    .login-box img {
      width: 120px;
      margin-bottom: 20px;
    }

    .login-box .welcome-text {
      font-size: 15px;
      color: #333;
      margin-bottom: 25px;
    }

    .login-box input[type="text"],
.login-box input[type="password"] {
  width: 100%;
  box-sizing: border-box;
  padding: 12px 14px;
  margin: 10px 0;
  border: 1px solid #dce3e8;
  border-radius: 8px;
  font-size: 14px;
  transition: border-color 0.3s;
  /* text-align: center; <= hapus jika tidak ingin teks ketengah */
}

    .login-box input[type="text"]:focus,
    .login-box input[type="password"]:focus {
      border-color: #1c92d2;
      outline: none;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      background-color: #1c92d2;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-box button:hover {
      background-color: #166ca5;
    }

    .login-box .links {
  margin-top: 15px;
  width: 100%; /* biar penuh */
  display: flex;
  justify-content: space-between; /* biar kiri-kanan */
  font-size: 13px;
}


    .login-box .links a {
      color: #1c92d2;
      text-decoration: none;
      transition: color 0.3s;
    }

    .login-box .links a:hover {
      color: #125b87;
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
  </style>
</head>
<body>
  <form class="login-box" action="{{ route('login.submit') }}" method="POST">
    @csrf

    <img src="{{ asset('storage/images/login.png') }}" alt="User Icon">

    <div class="welcome-text">Login dulu ya mas bro dan mba sis</div>

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
</body>
</html>
