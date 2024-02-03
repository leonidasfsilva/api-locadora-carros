<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'model',
        'brand',
        'plate'
    ];

    protected $hidden = [
        'status',
    ];
}
