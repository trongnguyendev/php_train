<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouses extends Model
{
     protected $fillable = [
        'name',
        'location'
    ];

    protected $table = 'warehouses'; 

}
