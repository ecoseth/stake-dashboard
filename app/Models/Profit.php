<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'auth_amount',
        'today_eth',
        'total_profit',
    ];
}
