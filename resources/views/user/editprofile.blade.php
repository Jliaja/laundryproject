<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
  <style>
    /* Styling form */
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
      background-color: #ffffffd9;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 20px;
      text-align: center;
    }

    form label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }

    form input,
    form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    form input[type="file"] {
      padding: 5px;
    }

    .profile-picture {
      text-align: center;
      margin-bottom: 20px;
    }

    .profile-picture img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
    }

    .button {
      margin-top: 20px;
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
    }

    .button:hover {
      background-color: #2980b9;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Edit Profil</h2>

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Foto Profil -->
      <div class="profile-picture">
        @if($user->profile_picture)
          <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil">
        @else
          <p>Foto Profil belum diunggah</p>
        @endif
      </div>

      <label for="profile_picture">Ubah Foto Profil</label>
      <input type="file" name="profile_picture" accept="image/*">

      <!-- Alamat -->
      <label for="address">Alamat</label>
      <textarea name="address" rows="3">{{ old('address', $user->address) }}</textarea>

      <!-- Email dan Password -->
      <h3>Ubah Email dan Password</h3>
      <label for="email">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

      <label for="password">Password Baru (opsional)</label>
      <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah">

      <button type="submit" class="button">Simpan Perubahan</button>
    </form>

    <a href="{{ route('user.profile') }}" class="back-link">⬅ Kembali ke Profil</a>
    <a href="{{ route('user.dashboard') }}" class="back-link">⬅ Kembali ke Dashboard</a>
  </div>

</body>
</html>
