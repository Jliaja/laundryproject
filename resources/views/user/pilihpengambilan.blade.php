<!DOCTYPE html>
<html>
<head>
    <title>Pilih Metode Pengambilan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f8f9fa; }
        .container { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        .mb-3 { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="radio"] { margin-right: 5px; }
        button { padding: 10px 20px; border: none; background: #007bff; color: white; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pilih Metode Pengambilan</h2>

        <form action="{{ route('user.pilihpengambilan.submit') }}" method="POST">
            @csrf

            <!-- Pastikan pesanan_id diteruskan dengan benar -->
            <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">

            <div class="mb-3">
                <label>Metode Pengambilan</label><br>
                <label><input type="radio" name="metode" value="antar_jemput" required> Antar Jemput</label><br>
                <label><input type="radio" name="metode" value="datang_sendiri" required> Datang Sendiri</label>
            </div>

            <button type="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
