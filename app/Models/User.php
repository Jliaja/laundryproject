<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'role', 'address','otp',
    'otp_expired_at',
    'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    // Login pakai username
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}
