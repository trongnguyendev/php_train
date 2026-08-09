<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return DB::table('leads as l')

            // Tỉnh / thành phố
            ->leftJoin('provinces as p', 'p.id', '=', 'l.province_id')

            // Loại khách hàng
            ->leftJoin(
                'customer_types as ct',
                'ct.id',
                '=',
                'l.customer_type_id'
            )

            // Showroom
            ->leftJoin(
                'showrooms as sh',
                'sh.id',
                '=',
                'l.showroom_id'
            )

            // Trạng thái khách hàng
            ->leftJoin(
                'customer_statuses as first_status',
                'first_status.id',
                '=',
                'l.first_customer_status_id'
            )

            ->leftJoin(
                'customer_statuses as current_status',
                'current_status.id',
                '=',
                'l.current_customer_status_id'
            )

            // Kênh hỗ trợ
            ->leftJoin(
                'support_channels as sc',
                'sc.id',
                '=',
                'l.support_channel_id'
            )

            // Nguồn khách hàng
            ->leftJoin(
                'customer_sources as source',
                'source.id',
                '=',
                'l.source_id'
            )

            // Người tạo
            ->leftJoin(
                'users as creator',
                'creator.id',
                '=',
                'l.created_by'
            )

            // Sale thông tin
            ->leftJoin(
                'sale_users as sale_info',
                'sale_info.id',
                '=',
                'l.sale_information_id'
            )

            // Sale hỗ trợ
            ->leftJoin(
                'sale_users as sale_support',
                'sale_support.id',
                '=',
                'l.sale_support_id'
            )

            ->select([
                'l.id',
                'l.customer_id',
                'l.first_interaction_date',
                'l.name',
                'l.phone',

                // Thông tin đã JOIN
                'p.name as province_name',
                'l.address',
                'l.zalo',

                'ct.name as customer_type_name',

                'sh.name as showroom_name',

                'first_status.name as first_status_name',

                'l.note',

                'sale_info.name as sale_information_name',

                'sale_support.name as sale_support_name',

                'current_status.name as current_status_name',

                'l.order_value',

                'sc.name as support_channel_name',

                'source.name as source_name',

                'l.customer_discussion_details',
                'l.tmdt',
                'l.lead_type',

                'creator.name as creator_name',

                'l.created_at',
                'l.updated_at',
                'l.order_code',
            ])

            ->orderBy('l.id');
    }

    public function headings(): array
    {
        return [
            'ID Lead',
            'Customer ID',
            'Ngày tương tác đầu tiên',
            'Tên khách hàng',
            'Số điện thoại',

            'Tỉnh/Thành phố',
            'Địa chỉ',
            'Zalo',

            'Loại khách hàng',
            'Showroom',

            'Trạng thái khách hàng đầu tiên',

            'Ghi chú',

            'Sale thông tin',
            'Sale hỗ trợ',

            'Trạng thái hiện tại',

            'Giá trị đơn hàng',

            'Kênh hỗ trợ',

            'Nguồn khách hàng',

            'Chi tiết trao đổi',

            'TMĐT',
            'Loại Lead',

            'Người tạo',

            'Ngày tạo',
            'Ngày cập nhật',

            'Mã đơn hàng',
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->customer_id,
            $lead->first_interaction_date,
            $lead->name,
            $lead->phone,

            $lead->province_name,
            $lead->address,
            $lead->zalo,

            $lead->customer_type_name,
            $lead->showroom_name,

            $lead->first_status_name,

            $lead->note,

            $lead->sale_information_name,
            $lead->sale_support_name,

            $lead->current_status_name,

            $lead->order_value,

            $lead->support_channel_name,

            $lead->source_name,

            $lead->customer_discussion_details,
            $lead->tmdt,
            $lead->lead_type,

            $lead->creator_name,

            $lead->created_at,
            $lead->updated_at,

            $lead->order_code,
        ];
    }
}