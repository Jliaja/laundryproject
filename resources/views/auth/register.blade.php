<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <style>
        body {
            background: linear-gradient(to right, #4ac6e8, #6be3f5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background-color: #ffffffdd;
            width: 420px;
            margin: 80px auto;
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-container img {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            display: block;
        }

        .form-container h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        .form-container label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin: 10px 0 5px;
            color: #333;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 12px;
            background-color: #f9f9f9;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-container input:focus,
        .form-container textarea:focus {
            border-color: #4ac6e8;
            background-color: #ffffff;
            outline: none;
            box-shadow: 0 0 8px rgba(74, 198, 232, 0.3);
        }

        .form-container button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .form-container button:hover {
            background-color: #1a2935;
        }

        .message {
            margin-top: 15px;
            color: red;
            font-size: 14px;
            background: #ffecec;
            padding: 10px;
            border-radius: 8px;
            text-align: left;
        }

        ul {
            padding-left: 18px;
            margin: 0;
        }

    </style>
</head>
<body>

    <div class="form-container">
        <img src="user-icon.png" alt="User Icon">
        <h2>Formulir Registrasi</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>

            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>

            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>

            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" required>

            <label for="address">Alamat</label>
            <textarea name="address" rows="3" class="form-control" required></textarea>

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
