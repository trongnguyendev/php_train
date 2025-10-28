<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
    'first_arrival_date',
    'name',
    'phone',
    'province_id',
    'address',
    'zalo',
    'customer_type_id',
    'is_new_customer',
    'customer_source_id',
    'product_category_id',
    'showroom_id',
    'first_customer_status_id',
    'note',
    'sale_receive_customer_info_id',
    'sale_support_id',
    'current_customer_status_id',
    'order_value',
    'support_status_customer_id',
    'exchange_content',
    'results',
    'lead_type'
    ];


    public function province() { 
        return $this->belongsTo(Province::class, 'province_id'); 
    }

    public function customerType() { 
        return $this->belongsTo(CustomerType::class, 'customer_type_id'); 
    }

    public function customerSource() { 
        return $this->belongsTo(CustomerSource::class, 'customer_source_id'); 
    }

    public function productCategory() { 
        return $this->belongsTo(ProductCategory::class, 'product_category_id'); 
    }

    public function showroom() { 
        return $this->belongsTo(Showroom::class, 'showroom_id'); 
    }

    public function firstStatus() { 
        return $this->belongsTo(CustomerStatus::class, 'first_customer_status_id'); 
    }

    public function currentStatus() { 
        return $this->belongsTo(CustomerStatus::class, 'current_customer_status_id'); 
    }

    public function saleReceive() { 
        return $this->belongsTo(SaleUser::class, 'sale_receive_customer_info_id'); 
    }

    public function saleSupport() { 
        return $this->belongsTo(SaleUser::class, 'sale_support_id'); 
    }


    public function leadTakeCares() { 
        return $this->hasMany(LeadTakeCare::class, 'lead_id'); 
    }
}
