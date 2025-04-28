<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form action="{{ route('password.reset') }}" method="POST">
        @csrf
        <div>
            <label for="password">Password baru</label>
            <input type="password" name="password" id="password" placeholder="Password baru" required>
        </div>
        <div>
            <label for="password_confirmation">Ulangi password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required>
        </div>
        <button type="submit">Reset Password</button>

        {{-- Pesan error jika ada --}}
        @if(session('error'))
            <p style="color:red;">{{ session('error') }}</p>
        @endif

        {{-- Pesan sukses jika ada --}}
        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif
    </form>
</body>
</html>
