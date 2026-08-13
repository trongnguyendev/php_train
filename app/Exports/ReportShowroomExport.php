<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportShowroomExport implements FromCollection, WithHeadings
{
    protected $result;
    protected $fromDate1;
    protected $toDate1;
    protected $fromDate2;
    protected $toDate2;

    public function __construct(
        $result,
        $fromDate1 = null,
        $toDate1 = null,
        $fromDate2 = null,
        $toDate2 = null
    ) {
        $this->result = $result;

        $this->fromDate1 = $fromDate1;
        $this->toDate1   = $toDate1;
        $this->fromDate2 = $fromDate2;
        $this->toDate2   = $toDate2;
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

                // Khoảng ngày hiện tại
                $row[] = $this->result['totals_current'][$showroom->id][$key] ?? 0;

                // Khoảng ngày trước
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

            // Khoảng ngày hiện tại
            $headings[] = $showroom->name
                . ' ('
                . $this->formatDate($this->fromDate1)
                . ' - '
                . $this->formatDate($this->toDate1)
                . ')';

            // Khoảng ngày trước
            $headings[] = $showroom->name
                . ' ('
                . $this->formatDate($this->fromDate2)
                . ' - '
                . $this->formatDate($this->toDate2)
                . ')';
        }

        return $headings;
    }

    /**
     * Format ngày Y-m-d -> d/m/Y
     */
    private function formatDate($date)
    {
        if (!$date) {
            return '';
        }

        return date('d/m/Y', strtotime($date));
    }
}