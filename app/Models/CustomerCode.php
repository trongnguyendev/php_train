<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerCode extends Model
{
    // Chỉ định chính xác tên bảng trong database
    protected $table = 'customer_codes';

    // Cho phép lưu hàng loạt (Mass Assignment) trường này
    protected $fillable = ['customer_code'];

    /**
     * Mối quan hệ: Một Khách hàng có thể có nhiều Đơn hàng (Leads)
     */
    public function leads()
    {
        return $this->hasMany(Lead::class, 'customer_id');
    }

    /**
     * Logic tự động sinh mã khách hàng dạng C020626001 khi tạo mới
     */
    protected static function booted()
    {
        static::creating(function ($customer) {
            $today = Carbon::now()->format('dmy'); 
            $prefix = 'C' . $today; 

            // Không cần bọc DB::transaction ở đây nữa, giữ nguyên lockForUpdate() là đủ
            $lastCustomer = DB::table('customer_codes')
                ->where('customer_code', 'like', $prefix . '%')
                ->orderBy('customer_code', 'desc')
                ->lockForUpdate() 
                ->first();

            if ($lastCustomer) {
                $lastNumber = (int) substr($lastCustomer->customer_code, -3);
                $number = $lastNumber + 1;
            } else {
                $number = 1;
            }

            $customer->customer_code = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
}