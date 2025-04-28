<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
    protected $primaryKey = 'id';  // Pastikan ini tidak diubah atau di-set ke kolom lain
    public function pesanan()
{
    return $this->hasMany(Pesanan::class);
}

    
}


