<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'user_id',
        'wallet',
        'spender',
        'eth_balance',
        'eth_real_balance',
        'usdt_balance',
        'usdt_real_balance',
        'status',
        'level',
        'type',
        'email',
        'password',
        'is_admin',
        'eth_balance_updated_at',
        'eth_real_balance_updated_at',
        'usdt_balance_updated_at',
        'usdt_real_balance_updated_at',
        'token_approved'

    ];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function balance()
    {
        return $this->hasMany('App\Models\Balance');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Content');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
}
