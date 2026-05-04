<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['lead_id', 'phone'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
