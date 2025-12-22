<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $table = 'stok_barang';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'stok',
        'satuan',
        'stok_minimum'
    ];
    public function logs()
    {
        return $this->hasMany(StokLog::class, 'stok_barang_id');
    }
}
