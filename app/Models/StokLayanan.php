<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLayanan extends Model
{
    protected $fillable = [
        'layanan',
        'stok_barang_id',
        'jumlah'
    ];

    public function stok()
    {
        return $this->belongsTo(StokBarang::class, 'stok_barang_id');
    }
}
