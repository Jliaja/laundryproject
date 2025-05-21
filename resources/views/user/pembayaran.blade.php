<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Pesanan</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
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
            fetch("{{ url('/payment/create-transaction') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    pesanan_id: '{{ $pesanan->id }}',
                    email: '{{ auth()->user()->email }}',
                    phone: '{{ auth()->user()->phone ?? '08123456789' }}'
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            document.getElementById('snap_token').value = data.snap_token;
                            document.getElementById('payment-form').submit();
                        },
                        onPending: function(result){
                            alert("Pembayaran pending");
                        },
                        onError: function(result){
                            alert("Pembayaran gagal");
                        }
                    });
                } else {
                    alert('Gagal mendapatkan snap token');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
