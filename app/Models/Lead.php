<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Lead extends Model
{
    protected $fillable = [
        'first_interaction_date',
        'name',
        'province_id',
        'address',
        'zalo',
        'customer_type_id',
        'showroom_id',
        'product_categories_id',
        'first_customer_status_id',
        'note',
        'sale_information_id',
        'sale_support_id',
        'current_customer_status_id',
        'order_value',
        'support_channel_id',
        'source_id',
        'customer_discussion_details',
        'tmdt',
        'lead_type'
    ];


    public function province() { 
        return $this->belongsTo(Province::class, 'province_id'); 
    }

    public function customerType() { 
        return $this->belongsTo(CustomerType::class, 'customer_type_id'); 
    }

    public function customerSource() { 
        return $this->belongsTo(CustomerSource::class, 'source_id'); 
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

    public function saleInformation() { 
        return $this->belongsTo(SaleUser::class, 'sale_information_id'); 
    }

    public function saleSupport() { 
        return $this->belongsTo(SaleUser::class, 'sale_support_id'); 
    }

    public function supportedChannel() { 
        return $this->belongsTo(SupportChannel::class, 'support_channel_id'); 
    }

    public function leadTakeCares() { 
        return $this->hasMany(LeadTakeCare::class, 'lead_id'); 
    }

    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'lead_product_category', 'lead_id', 'product_category_id');
    }
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    protected static function booted()
    {
        static::creating(function ($lead) {

            $today = Carbon::now()->format('dmy');

            $count = DB::table('leads')
                ->whereDate('created_at', Carbon::today())
                ->count();

            $number = $count + 1;

            $lead->customer_code = 'C' . $today . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
}
