<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
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

    .reset-box {
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

    h1 {
      margin-bottom: 20px;
      color: #2c3e50;
      font-size: 24px;
    }

    input[type="password"] {
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

    input[type="password"]:focus {
      outline: none;
      background-color: #ffffff;
      box-shadow: 0 0 8px rgba(74, 198, 232, 0.3);
    }

    button {
      width: 100%;
      padding: 12px;
      background: #2c3e50;
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
      padding: 10px;
      border-radius: 8px;
    }

    .error-message {
      background: #ffecec;
      color: red;
    }

    .success-message {
      background: #e3ffe8;
      color: green;
    }
  </style>
</head>
<body>
  <form class="reset-box" action="{{ route('password.reset') }}" method="POST">
    @csrf
    <h1>Reset Password</h1>

    <input type="password" name="password" placeholder="Password baru" required>
    <input type="password" name="password_confirmation" placeholder="Ulangi password" required>

    <button type="submit">Reset Password</button>

    {{-- Pesan error jika ada --}}
    @if(session('error'))
      <div class="message error-message">{{ session('error') }}</div>
    @endif

    {{-- Pesan sukses jika ada --}}
    @if(session('success'))
      <div class="message success-message">{{ session('success') }}</div>
    @endif
  </form>
</body>
</html>
