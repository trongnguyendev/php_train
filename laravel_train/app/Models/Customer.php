<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $fillable = [
        'start_date',
        'name',
        'phone',
        'province',
        'address',
        'type_customer',
        'page_source',
        'sale_product',
        'first_guest_status',
        'note',
        'sale_infor',
        'current_guest_status',
        'information_exchange',
        'results',
        'take_care_guest_first_one',
        ];
        
    protected $table = 'customer'; 

    public function CustomerStatus() {
        return $this->hasOne();
    }

    public function CustomerType() {
        return $this->hasMany(CustomerType::class);
    }
}
