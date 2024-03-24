<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'usdt_balance',
        'usdt_auth_amount',
        'eth_balance',
        'eth_auth_amount',
        'today_eth',
        'total_profit_eth',
        'today_usdt',
        'total_profit_usdt',
        'created_by',
        'updated_by'

    ];
}
