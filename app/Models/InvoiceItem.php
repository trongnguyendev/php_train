<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'subtotal',
        'manual_discount_type',
        'manual_discount_percent',
        'manual_discount_amount',
        'retail_discount',
        'discount_total',
        'total',
    ];

    /**
     * Quan hệ tới bảng Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Quan hệ tới bảng Invoice
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}