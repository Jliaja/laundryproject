<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: 
                linear-gradient(rgba(220, 233, 249, 0.85), rgba(244, 248, 251, 0.85)),
                url('/storage/images/backgroudlandry.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-dark);
            min-height: 100vh;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .success-message, .error-message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .pay-button {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
            .pay-button1 {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        .pay-button:hover {
            background-color: #218838;
        }
        .pay-button[disabled] {
            background-color: #6c757d;
            cursor: not-allowed;
        }
    </style>
    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>

<h1>Daftar Pesanan</h1>

@if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="error-message">
        {{ session('error') }}
    </div>
@endif

@if($pesanan->isEmpty())
    <p style="text-align: center;">Tidak ada pesanan ditemukan.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Pesanan ID</th>
                <th>Layanan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Status Pesanan</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->sortBy('status') as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->layanan }}</td>
                    <td>{{ $p->jumlah }} kg</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        @if($p->status == 'selesai' && empty($p->metode_pengambilan))
                            <a href="{{ route('user.pilihpengambilan', ['pesanan_id' => $p->id]) }}">Atur Pengambilan</a>
                        @else
                            {{ ucfirst($p->status) }}
                        @endif
                    </td>
                    <td>
                        @if($p->status_pembayaran == 'pending')
                            <span style="color: orange;">Belum Dibayar</span>
                        @elseif($p->status_pembayaran == 'selesai')
                            <span style="color: green;">Sudah Dibayar</span>
                        @elseif($p->status_pembayaran == 'gagal')
                            <span style="color: red;">Pembayaran Gagal</span>
                        @else
                            <span style="color: gray;">Status Tidak Diketahui</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status_pembayaran == 'pending')
                            <button class="pay-button" 
                                    data-id="{{ $p->id }}" 
                                    data-email="{{ auth()->user()->email }}" 
                                    data-phone="{{ auth()->user()->phone ?? '08123456789' }}">
                                Bayar
                            </button>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->status == 'selesai' && $p->status_pembayaran == 'selesai')
                            <a href="{{ route('user.downloadinvoice', $p->id) }}" class="pay-button1" style="background-color:#007bff">
                                Download Invoice
                            </a>
                        @elseif($p->status == 'selesai' && $p->status_pembayaran != 'selesai')
                            <span style="font-size: 12px; color: red;">Selesaikan pembayaran</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<a class="back-link" href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>

<script>
document.querySelectorAll('.pay-button').forEach(button => {
    button.addEventListener('click', async function () {
        const pesananId = this.dataset.id;
        const email = this.dataset.email;
        const phone = this.dataset.phone;
        this.disabled = true;
        this.textContent = "Memproses...";

        try {
            const response = await fetch("{{ url('/payment/create-transaction') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    pesanan_id: pesananId,
                    email: email,
                    phone: phone
                }),
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        alert("Pembayaran berhasil! Redirect ke daftar pesanan dalam 5 detik...");
                        setTimeout(() => {
                            window.location.href = "{{ route('user.daftarpesanan') }}";
                        }, 5000);
                    },
                    onPending: function(result){
                        alert("Pembayaran tertunda. Redirect dalam 5 detik...");
                        setTimeout(() => {
                            window.location.href = "{{ route('user.daftarpesanan') }}";
                        }, 5000);
                    },
                    onError: function(result){
                        alert("Pembayaran gagal. Redirect dalam 5 detik...");
                        setTimeout(() => {
                            window.location.href = "{{ route('user.daftarpesanan') }}";
                        }, 5000);
                    },
                    onClose: function(){
                        alert("Kamu menutup popup pembayaran.");
                    }
                });
            } else {
                alert('Gagal mendapatkan token pembayaran.');
                this.disabled = false;
                this.textContent = "Bayar";
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pembayaran.');
            this.disabled = false;
            this.textContent = "Bayar";
        }
    });
});
</script>

</body>
</html>
