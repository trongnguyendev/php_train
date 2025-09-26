<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'customer_for_showroom',
        'name',
        'phone',
        'province_id',
        'address',
        'zalo_feedback',
        'type_customer_yet_id',
        'type_customer_id',
        'type_showroom_id',
        'type_category_id',
        'status_first_id',
        'note_sale',
        'salename_infor_id',
        'salename_support_id',
        'current_status_id',
        'order_value',
        'customer_support_yet_id',
    ];

    // Quan hệ với Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    // Quan hệ với loại khách hàng

    public function typeCustomerYet()
    {
        return $this->belongsTo(TypeCustomer::class, 'type_customer_yet_id');
    }

    public function typeCustomer()
    {
        return $this->belongsTo(TypeCustomer::class, 'type_customer_id');
    }


    public function typeShowroom()
    {
        return $this->belongsTo(TypeShowroom::class, 'type_showroom_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'type_category_id');
    }

    // Quan hệ với Status
    public function statusFirst()
    {
        return $this->belongsTo(Status::class, 'status_first_id');
    }

    public function currentStatus()
    {
        return $this->belongsTo(Status::class, 'current_status_id');
    }

    // Quan hệ với SaleName
    public function salenameInfor()
    {
        return $this->belongsTo(SaleName::class, 'salename_infor_id');
    }

    public function salenameSupport()
    {
        return $this->belongsTo(SaleName::class, 'salename_support_id');
    }

    public function cateloryProduct()
    {
        return $this->belongsTo(Category::class, 'type_category_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'customer_support_yet_id');
    }
}
