<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Importreceipt extends Model
{
    protected $fillable = [
        'warehouse_id',
        'code',
        'received_at'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouses::class);
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'importreceipt_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
