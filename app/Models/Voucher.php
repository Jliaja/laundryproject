<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'kode', 'tipe', 'nilai', 'stok', 'terpakai', 'masa_berlaku'
    ];
}
