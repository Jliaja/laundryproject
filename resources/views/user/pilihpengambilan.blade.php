<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Pengambilan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
        }

        .form-container {
            display: block;
        }

        .form-hidden {
            display: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        .radio-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .radio-group label {
            font-weight: normal;
            margin-left: 5px;
        }

        /* Tombol "Kembali ke Daftar Pesanan" */
        .btn-back {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
                width: 100%;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <h2>Pilih Metode Pengambilan</h2>

    <div class="container">
        @if(session('success'))
            <!-- Menampilkan pesan sukses -->
            <div class="alert">
                {{ session('success') }}
            </div>

            <!-- Tombol "Kembali ke Daftar Pesanan" setelah submit -->
            <form action="{{ route('user.daftarpesanan') }}" method="GET">
                <button type="submit" class="btn-back">Kembali ke Daftar Pesanan</button>
            </form>
        @else
            <div class="form-container" id="form-container">
                <div style="background: #f8f9fa; padding: 15px; border: 1px solid #ccc; margin-bottom: 20px;">
                <form action="{{ route('user.pilihpengambilan.submit') }}" method="POST">
                    @csrf

                    <!-- Pastikan pesanan_id diteruskan dengan benar -->
                    <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">

                    <div class="form-group">
                        <label for="metode">Pilih Metode Pengambilan:</label>
                        <div class="radio-group">
                            <label><input type="radio" name="metode" value="antar" required> Antar ke Rumah (Ongkir 5rb) </label>
                            <label><input type="radio" name="metode" value="ambil" required> Ambil Sendiri</label>
                        </div>
                    </div>

                    <!-- Jika memilih antar jemput, tampilkan input alamat -->
                    <div id="address" style="display:none;" class="form-group">
    <label for="alamat">Alamat Pengambilan:</label>
    <input type="text" name="alamat" value="{{ old('alamat', $address ?? '') }}" placeholder="Masukkan alamat">
</div>

                    <button type="submit">Kirim</button>
                </form>
            </div>
        @endif
    </div>

    <script>
        // Menampilkan input alamat jika memilih antar jemput
        document.querySelectorAll('input[name="metode"]').forEach((elem) => {
            elem.addEventListener('change', function() {
                if (this.value === 'antar') {
                    document.getElementById('alamat').style.display = 'block';
                } else {
                    document.getElementById('alamat').style.display = 'none';
                }
            });
        });

        // Setelah form disubmit dan pesan sukses ada, sembunyikan form
        @if(session('success'))
            document.getElementById('form-container').classList.add('form-hidden');
        @endif
    </script>

</body>
</html>
