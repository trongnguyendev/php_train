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
        return $this->belongsTo(User::class, 'sale_information_id'); 
    }

    public function saleSupport() { 
        return $this->belongsTo(User::class, 'sale_support_id'); 
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
            // Sử dụng Database Transaction và Lock để chống trùng lặp tuyệt đối
            DB::transaction(function () use ($lead) {
                $today = Carbon::now()->format('dmy'); // Định dạng: 300526
                $prefix = 'C' . $today; // C300526

                // Tìm mã lớn nhất trong ngày hôm nay và khóa dòng đó lại để xử lý
                $lastLead = DB::table('leads')
                    ->where('customer_code', 'like', $prefix . '%')
                    ->orderBy('customer_code', 'desc')
                    ->lockForUpdate() 
                    ->first();

                if ($lastLead) {
                    // Cắt 3 số cuối của mã lớn nhất hiện tại và chuyển thành số nguyên
                    $lastNumber = (int) substr($lastLead->customer_code, -3);
                    $number = $lastNumber + 1;
                } else {
                    // Nếu chưa có lead nào trong ngày
                    $number = 1;
                }

                // Gán mã hoàn chỉnh vào model
                $lead->customer_code = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
            });
        });
    }
}
