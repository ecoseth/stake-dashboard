<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;


class Content extends Model
{
    use HasFactory;
    use HasTrixRichText;

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
