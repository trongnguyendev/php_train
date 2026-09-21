<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'action',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * 1. Quan hệ lấy thông tin Người thao tác log (User thực hiện action)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 2. Quan hệ polymorphic đến Model gốc (Ví dụ: Lead, Order...)
     * Giúp bạn gọi $log->auditable để lấy trực tiếp Model được sửa
     */
    public function auditable()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }

    /**
     * 3. Helper lấy dữ liệu ưu tiên (Mới trước -> Cũ sau)
     */
    public function getDataAttribute()
    {
        return !empty($this->new_values) ? $this->new_values : ($this->old_values ?? []);
    }

    /**
     * 4. Helper lấy tên hiển thị của các ID danh mục nhanh ngay trong Model
     * Dùng: $log->getRelationName('province_id', \App\Models\Province::class)
     */
    public function getRelationName($key, $modelClass, $field = 'name', $isNew = true)
    {
        $values = $isNew ? ($this->new_values ?? []) : ($this->old_values ?? []);
        $id = $values[$key] ?? null;

        if (!$id) {
            return '---';
        }

        $item = $modelClass::find($id);
        return $item ? ($item->{$field} ?? $id) : $id;
    }
}