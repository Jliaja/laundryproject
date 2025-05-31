<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi</title>
  <style>
  :root {
    --primary: #a0d8ef; /* ice blue */
    --primary-dark: #6fbdd3;
    --background: #f7fcff;
    --card-bg: #ffffff;
    --text-dark: #2e3d49;
    --error-bg: #ffecec;
    --error-text: #d9534f;
  }

  body {
    background: 
      linear-gradient(rgba(255, 255, 255, 0.95), rgba(224, 244, 255, 0.9)),
      url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    color: var(--text-dark);
  }

  .register-box {
    background: var(--card-bg);
    padding: 40px 30px;
    border-radius: 18px;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    width: 400px;
    animation: fadeIn 0.5s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .register-box img {
    width: 110px;
    margin: 0 auto 30px;
    display: block;
  }

  .register-box h2 {
    text-align: center;
    margin-bottom: 20px;
    color: var(--text-dark);
  }

  .register-box label {
    font-weight: bold;
    display: block;
    margin-top: 15px;
    color: #34495e;
  }

  .register-box input,
  .register-box textarea {
    width: 100%;
    padding: 12px 14px;
    margin-top: 6px;
    border: 1px solid #cfe7f1;
    border-radius: 10px;
    background: #f9fcff;
    transition: all 0.3s;
    font-size: 14px;
    box-sizing: border-box;
  }

  .register-box input:focus,
  .register-box textarea:focus {
    border-color: var(--primary);
    background: #ffffff;
    outline: none;
  }

  .register-box button {
    width: 100%;
    margin-top: 25px;
    padding: 12px;
    background-color: var(--primary);
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 10px;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .register-box button:hover {
    background-color: var(--primary-dark);
  }

  .message {
    margin-top: 18px;
    color: var(--error-text);
    background: var(--error-bg);
    padding: 12px;
    border-radius: 10px;
    font-size: 14px;
  }

  ul {
    margin: 0;
    padding-left: 20px;
  }
</style>

</head>
<body>
  <div class="register-box">
    <img src="{{ asset('storage/images/login.png') }}" alt="User Icon">
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

      <label for="verifikasi_kode">Kode Verifikasi</label>
      <input type="text" name="verifikasi_kode" placeholder="Masukkan kode" required>

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
