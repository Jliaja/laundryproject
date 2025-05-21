<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans'; // Nama tabel dalam database

    protected $fillable = [
    'user_id',
    'nama_pelanggan',
    'layanan',
    'jumlah',
    'total_harga',
    'tanggal',
    'status',
    'status_pembayaran',
    'metode_pengambilan',
    'address',
    'invoice_url',
    'order_id'
];


    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan Transaksi
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
