<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ganti Password</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #4ac6e8, #a1e0f3);
      padding: 50px;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      background-color: #ffffffd9;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 20px;
    }

    label {
      font-size: 16px;
      color: #333;
      display: block;
      margin-bottom: 8px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 16px;
    }

    .btn-success {
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
      border: none;
    }

    .btn-success:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Ganti Password</h2>
    <form action="{{ route('user.gantipassword') }}" method="POST">
      @csrf
      <label>Password Lama</label>
      <input type="password" name="password_lama" required class="form-control"><br>

      <label>Password Baru</label>
      <input type="password" name="password_baru" required class="form-control"><br>

      <button type="submit" class="btn-success">Update Password</button>
    </form>
  </div>

</body>
</html>
