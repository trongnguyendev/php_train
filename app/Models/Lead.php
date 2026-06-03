<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Lead extends Model
{
    protected $fillable = [
        'customer_id', // 1. THÊM TRƯỜNG NÀY ĐỂ LƯU ID KHÁCH HÀNG TỪ BẢNG CUSTOMER_CODES
        'order_code',  // 2. ĐỔI TỪ customer_code THÀNH order_code
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
        'lead_type',
        'created_by', // 3. THÊM TRƯỜNG NÀY ĐỂ LƯU ID NGƯỜI TẠO
    ];
    
    /**
     * 3. THÊM MỐI QUAN HỆ: Một Đơn hàng (Lead) sẽ thuộc về một Mã khách hàng nhất định
     */
    public function customerCode() 
    { 
        return $this->belongsTo(CustomerCode::class, 'customer_id'); 
    }

    
    public function creator(): BelongsTo
    {
        // 'created_by' là tên cột bạn vừa tạo ở bảng leads
        // 'id' là khóa chính bên bảng users
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

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


    /**
     * 4. SỬA LOGIC TỰ SINH MÃ: Chuyển từ sinh mã khách hàng sang sinh MÃ ĐƠN HÀNG (order_code)
     */
    // Trong app/Models/Lead.php
    protected static function booted()
    {
        static::creating(function ($lead) {
            DB::transaction(function () use ($lead) {
                
                // 1. Tìm thông tin mã khách hàng từ customer_id
                $customer = DB::table('customer_codes')->where('id', $lead->customer_id)->first();
                
                if ($customer) {
                    // 2. Đếm số đơn hiện tại của khách hàng này
                    $orderCount = DB::table('leads')
                        ->where('customer_id', $lead->customer_id)
                        ->count();
                    
                    // 3. Đơn tiếp theo tăng lên 1
                    $nextNumber = $orderCount + 1;
                    
                    // Gán mã đơn theo cấu trúc: MãKhách-SốĐơn (Ví dụ: C020626001002)
                    $lead->order_code = $customer->customer_code . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                }
            });
        });
    }
}

