<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'page',
        'title',
        'content',
        'author',
        'sort'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','author','id');
    }
}
