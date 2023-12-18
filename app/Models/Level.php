<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
       'id',
       'name',
       'min_amount',
       'max_amount',
       'percentage',
       'created_by',
       'created_at',
       'updated_at'
    ];
}
