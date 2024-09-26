<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortingTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name','order', 'status','date'
    ];
        
}
