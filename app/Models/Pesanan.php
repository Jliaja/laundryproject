<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans'; // <-- Tambahkan ini

    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'layanan',
        'jumlah',
        'tanggal',
        'status',
    ];
    

    // App\Models\Pesanan.php

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
