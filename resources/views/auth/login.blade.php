<style>
  body {
    background: linear-gradient(to right, #6dd5fa, #2980b9);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .login-box {
    background: #fff;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    text-align: center;
    width: 340px;
  }

  .login-box img {
    width: 60px;
    margin-bottom: 20px;
  }

  .login-box input[type="text"],
  .login-box input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
  }

  .login-box input:focus {
    border-color: #2980b9;
  }

  .login-box button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .login-box button:hover {
    background-color: #1c5980;
  }

  .login-box .links {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
    font-size: 13px;
  }

  .login-box .links a {
    color: #2980b9;
    text-decoration: none;
    transition: color 0.3s;
  }

  .login-box .links a:hover {
    color: #1c5980;
  }

  .message {
    margin-top: 15px;
    font-size: 14px;
  }

  .success {
    color: green;
  }

  .error {
    color: red;
  }
</style>
</head>
<body>
  <form class="login-box" action="{{ route('login.submit') }}" method="POST">
    @csrf

    <img src="{{ asset('user-icon.png') }}" alt="User Icon">

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
