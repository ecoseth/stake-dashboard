<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $table = 'Exchange';

    protected $fillable = [
        'usdt',
        'open_time',
        'close_time',
    ];
}
