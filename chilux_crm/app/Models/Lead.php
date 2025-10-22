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


    public function leadTakeCare()
    {
        return $this->hasOne(LeadTakeCare::class, 'lead_id');
    }

    public function province() { return $this->belongsTo(Province::class); }
    public function customerType() { return $this->belongsTo(CustomerType::class); }
    public function customerSource() { return $this->belongsTo(CustomerSource::class); }
    public function productCategory() { return $this->belongsTo(ProductCategory::class); }
    public function showroom() { return $this->belongsTo(Showroom::class); }
    public function firstStatus() { return $this->belongsTo(CustomerStatus::class, 'first_customer_status_id'); }
    public function saleReceive() { return $this->belongsTo(User::class, 'sale_receive_customer_info_id'); }
    public function saleSupport() { return $this->belongsTo(User::class, 'sale_support_id'); }
    public function currentStatus() { return $this->belongsTo(CustomerStatus::class, 'current_customer_status_id'); }
    public function supportStatus() { return $this->belongsTo(CustomerSource::class, 'support_status_customer_id'); }
    public function leadTakeCares() { return $this->hasMany(LeadTakeCare::class, 'lead_id'); }

}
