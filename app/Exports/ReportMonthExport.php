<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportMonthExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $dataPrev;

    public function __construct($data, $dataPrev)
    {
        $this->data = $data;
        $this->dataPrev = $dataPrev;
    }

    public function collection()
    {
        $rows = collect();

        // Tháng hiện tại
        $rows->push(['=== THÁNG HIỆN TẠI ===']);

        foreach ($this->data as $row) {
            $rows->push([
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
            ]);
        }

        $rows->push([]);

        // Tháng trước
        $rows->push(['=== THÁNG TRƯỚC ===']);

        foreach ($this->dataPrev as $row) {
            $rows->push([
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
            ]);
        }

        return $rows;
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