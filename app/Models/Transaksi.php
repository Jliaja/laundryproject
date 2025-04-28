<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // <-- Tambahkan ini

    protected $fillable = [
        'pesanan_id',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
