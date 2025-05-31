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
    document.querySelectorAll('.btn-bayar').forEach(button => {
        button.addEventListener('click', function () {
            const pesananId = this.dataset.id;
            const email = this.dataset.email;
            const phone = this.dataset.phone;

            fetch("{{ url('/payment/create-transaction') }}", {
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
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            alert("Pembayaran berhasil!");
                            setTimeout(() => {
                                window.location.href = "{{ route('user.daftarpesanan') }}";
                            }, 5000); // redirect dalam 5 detik
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
    });
</script>

</body>
</html>
