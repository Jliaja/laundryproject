<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    protected $table = 'hargas'; // ← pastikan sesuai nama tabel

    protected $fillable = ['layanan', 'hargaPerKg'];

    // FIX untuk camelCase agar tetap terbaca
    public function getHargaPerKgAttribute($value)
    {
        return $value;
    }
}
