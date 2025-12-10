<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Voucher</title>
  <style>
body {
  background: 
    url('/storage/images/backgroudlandry.jpeg') 
    no-repeat center center fixed;
  background-size: cover;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  color: #2c3e50;
}

/* Heading */
h3 {
  font-size: 26px;
  font-weight: 700;
  color: #2563eb;
  margin-bottom: 20px;
}

/* Card */
.card {
  background-color: #ffffffd9;
  border-radius: 12px;
  padding: 25px 25px 35px 25px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  transition: box-shadow 0.3s ease;
  margin-bottom: 30px;
}

.card:hover {
  box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

label {
  font-weight: 600;
  color: #333;
  margin-bottom: 6px;
}

input, select {
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  width: 100%;
  transition: border-color 0.3s ease;
}

input:focus, select:focus {
  border-color: #4ac6e8;
  outline: none;
}

/* Button */
.btn-primary {
  background-color: #2563eb;
  border-color: #2563eb;
  padding: 10px 20px;
  font-weight: 600;
}

.btn-primary:hover {
  background-color: #1d4ed8;
}

.btn-danger {
  background-color: #dc2626;
  border-color: #dc2626;
}

.btn-danger:hover {
  background-color: #b91c1c;
}

/* Table */
table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin-top: 20px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

th, td {
  padding: 12px 15px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #4ac6e8;
  color: white;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .05em;
}

tbody tr:nth-child(even) {
  background-color: #f9f9f9;
  transition: background-color 0.3s ease;
}

tbody tr:hover {
  background-color: #e0f7ff;
}

/* Alert */
.alert-success {
  background-color: #bbf7d0;
  border-left: 6px solid #16a34a;
  padding: 12px 15px;
  border-radius: 6px;
  font-weight: 600;
}

@media(max-width: 768px) {
  .row > div {
    margin-bottom: 15px;
  }
}
</style>
</head>
<body>

<div class="container mt-4">
    <h3>Kelola Voucher Diskon</h3>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Form Tambah Voucher -->
    <div class="card mt-3">
        <div class="card-body">
            <form action="/admin/voucher" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-3">
                        <label>Kode Voucher</label>
                        <input type="text" name="kode" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Tipe Diskon</label>
                        <select name="tipe" class="form-control">
                            <option value="persen">Persen (%)</option>
                            <option value="nominal">Nominal (Rp)</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Nilai</label>
                        <input type="number" name="nilai" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Masa Berlaku</label>
                        <input type="date" name="masa_berlaku" class="form-control" required>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Buat Voucher</button>
            </form>
        </div>
    </div>

    <!-- Daftar Voucher -->
    <div class="card mt-4">
        <div class="card-body">
            <h5>Daftar Voucher</h5>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tipe</th>
                        <th>Nilai</th>
                        <th>Stok</th>
                        <th>Terpakai</th>
                        <th>Masa Berlaku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $v)
                    <tr>
                        <td>{{ $v->kode }}</td>
                        <td>{{ ucfirst($v->tipe) }}</td>
                        <td>
                            @if($v->tipe == 'persen')
                                {{ $v->nilai }}%
                            @else
                                Rp {{ number_format($v->nilai, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>{{ $v->stok }}</td>
                        <td>{{ $v->terpakai }}</td>
                        <td>{{ $v->masa_berlaku }}</td>
                        <td>
                            <form action="/admin/voucher/{{ $v->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus voucher ini?')">
                                    Hapus
                                </button>
                                
                            </form>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><a class="back-link" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
    </div>

</div>

