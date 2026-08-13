<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportShowroomExport implements FromCollection, WithHeadings
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function collection()
    {
        $rows = [];

        foreach ($this->result['metrics'] as $label => $key) {

            $row = [];

            // Tên chỉ tiêu
            $row[] = $label;

            // Dữ liệu từng showroom
            foreach ($this->result['showrooms'] as $showroom) {

                $row[] = $this->result['totals_current'][$showroom->id][$key] ?? 0;

                $row[] = $this->result['totals_prev'][$showroom->id][$key] ?? 0;
            }

            $rows[] = $row;
        }

        return new Collection($rows);
    }

    public function headings(): array
    {
        $headings = ['Chỉ tiêu'];

        foreach ($this->result['showrooms'] as $showroom) {

            $headings[] = $showroom->name . ' (Tháng này)';
            $headings[] = $showroom->name . ' (Tháng trước)';
        }

        return $headings;
    }
}