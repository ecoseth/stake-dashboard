<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'statistics_eth',
        'frozen_eth',
        'statistics_usdt',
        'frozen_usdt',
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

}
