<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleName extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    protected $table = 'sale_names'; 
}
