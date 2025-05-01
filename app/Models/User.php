<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'role', 'address',
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username'; // Ganti dari 'email' ke 'username'
    }

    protected $primaryKey = 'id';  // Pastikan 'id' adalah primary key
    protected $keyType = 'int';    // Pastikan key type adalah integer
    public $incrementing = true;   // Pastikan incrementing diatur ke true

    // Relasi dengan Pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
