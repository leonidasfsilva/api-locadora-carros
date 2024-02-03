<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{

    protected $table = 'cars_users_assoc';
    
    protected $fillable = [
        'id_car',
        'id_user',
    ];

    protected $hidden = [
        'status',
    ];
}
