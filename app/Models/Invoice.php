<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'lead_id',
        'invoice_code',

        // Thông tin khách hàng
        'customer_name',
        'customer_phone',
        'customer_address',

        // Các khoản tính toán tiền
        'subtotal',
        'discount_manual',
        'discount_retail',
        'discount_total',

        // Tiền Cọc, Phí & Số tiền còn lại
        'deposit_amount',
        'deposit_type',
        'other_fee',
        'remaining',

        'grand_total',

        // Thông tin thanh toán & bán hàng
        'payment_method',
        'note',
        'sale_name',
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'discount_manual' => 'decimal:2',
        'discount_retail' => 'decimal:2',
        'discount_total'  => 'decimal:2',
        'deposit_amount'  => 'decimal:2',
        'other_fee'       => 'decimal:2',
        'remaining'       => 'decimal:2',
        'grand_total'     => 'decimal:2',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    

}