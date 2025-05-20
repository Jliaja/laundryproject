<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: 
        linear-gradient(rgba(220, 233, 249, 0.85), rgba(244, 248, 251, 0.85)),
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: var(--text-dark);
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 60px auto;
      background-color: #ffffffee;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      animation: slideUp 0.6s ease;
    }

    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 25px;
      text-align: center;
      font-size: 28px;
    }

    .profile-picture {
      text-align: center;
      margin-bottom: 25px;
    }

    .profile-picture img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #2f80ed;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .info {
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }

    .info strong {
      display: inline-block;
      width: 100px;
      color: #2f80ed;
    }

    .link-group {
      margin-top: 30px;
      text-align: center;
    }

    .back-link {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      background-color: #2f80ed;
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .back-link:hover {
      background-color: #1c60d1;
    }

    .no-photo {
      background: #e0e0e0;
      width: 140px;
      height: 140px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Profil Saya</h2>

    <!-- Foto Profil -->
    <div class="profile-picture">
      @if($user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil">
      @else
        <div class="no-photo">Tidak ada foto</div>
      @endif
    </div>

    <div class="info">
      <p><strong>Username:</strong> {{ $user->username }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>
      <p><strong>Alamat:</strong> {{ $user->address }}</p>
    </div>

    <div class="link-group">
      <a href="{{ route('user.profile.edit') }}" class="back-link">Edit Profil</a>
      <a href="{{ route('user.dashboard') }}" class="back-link">Kembali ke Dashboard</a>
    </div>
  </div>

</body>
</html>
