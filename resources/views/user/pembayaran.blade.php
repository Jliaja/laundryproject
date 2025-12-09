<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Pesanan</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: 
        
        url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
      background-size: cover
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        ul {
            max-width: 500px;
            margin: 0 auto 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            list-style: none;
        }

        ul li {
            margin: 10px 0;
            font-size: 16px;
        }

        strong {
            color: #2c3e50;
        }

        #pay-button {
            display: block;
            margin: 0 auto;
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #pay-button:hover {
            background-color: #27ae60;
        }

        @media (max-width: 600px) {
            ul {
                padding: 15px;
                font-size: 15px;
            }

            #pay-button {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <h1>Bayar Pesanan</h1>

    <ul>
        <li><strong>Layanan:</strong> {{ $pesanan->layanan }}</li>
        <li><strong>Jumlah:</strong> {{ $pesanan->jumlah }} kg</li>
        <li><strong>Total Harga:</strong> Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</li>
    </ul>

    <button id="pay-button">Bayar Sekarang</button>

    <form id="payment-form" method="POST" action="{{ route('user.bayar.submit', $pesanan->id) }}">
        @csrf
        <input type="hidden" name="snap_token" id="snap_token">
        <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
    </form>

    <script>
    document.getElementById('pay-button').addEventListener('click', function () {
        const pesananId = "{{ $pesanan->id }}";
        const email = "{{ auth()->user()->email }}";
        const phone = "{{ auth()->user()->phone ?? '08123456789' }}";

        fetch("{{ url('api/payment/createTransaction') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                pesanan_id: pesananId,
                email: email,
                phone: phone
            }),
        })
        .then(response => {
            if (!response.ok) throw new Error('Response not OK');
            return response.json();
        })
        .then(data => {
            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        alert("Pembayaran berhasil!");
                        setTimeout(() => {
                            window.location.href = "{{ route('user.daftarpesanan') }}";
                        }, 5000);
                    },
                    onPending: function(result){
                        alert("Pembayaran tertunda.");
                        setTimeout(() => {
                            window.location.href = "{{ route('user.daftarpesanan') }}";
                        }, 5000);
                    },
                    onError: function(result){
                        alert("Pembayaran gagal.");
                        setTimeout(() => {
                            window.location.href = "{{ route('user.daftarpesanan') }}";
                        }, 5000);
                    },
                    onClose: function(){
                        alert('Pembayaran dibatalkan.');
                    }
                });
            } else {
                alert('Gagal mendapatkan token pembayaran.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });
    </script>

</body>
</html>
