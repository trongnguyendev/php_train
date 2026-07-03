<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ReportDailyExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($row) {
            return [
                $row->sale_name,
                $row->total_customers,
                $row->total_new_customers,
                $row->total_old_customers,
                $row->total_new_potential,
                $row->total_old_potential,
                $row->total_potential,
                $row->total_care,
                $row->total_new_locked,
                $row->total_old_locked,
                $row->total_value,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sale',
            'Tổng KH',
            'KH Mới',
            'KH Cũ',
            'KH Mới Tiềm năng',
            'KH Cũ Tiềm năng',
            'Tổng Tiềm năng',
            'Quan tâm',
            'KH Mới Đã chốt',
            'KH Cũ Đã chốt',
            'Doanh số',
        ];
    }
}