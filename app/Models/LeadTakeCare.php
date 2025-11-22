<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadTakeCare extends Model
{
    protected $fillable = [
        'lead_id',
        'take_care_plan',
        'take_care_date',
        'take_care_result'
    ];

    protected $casts = [
        'take_care_date' => 'date',
    ];
    
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
