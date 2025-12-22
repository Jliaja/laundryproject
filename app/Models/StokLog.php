<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $fillable = [
        'stok_barang_id','tipe','jumlah','keterangan'
    ];

    public $timestamps = false;

    public function stok()
    {
        return $this->belongsTo(StokBarang::class, 'stok_barang_id');
    }
}

