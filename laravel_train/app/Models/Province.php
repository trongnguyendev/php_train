<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    protected $table = 'provinces'; 

}
