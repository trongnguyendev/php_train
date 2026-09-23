@extends('layouts.app')

@section('content')
<div class="container-fluid px-4"> 
    <h1 class="h3 mb-4">
        <i class="bi bi-building text-info"></i>
        <span class="text-primary fw-bold">Chi tiết Lead</span>
        @if($lead->lead_type == 2)
            <span class="badge bg-info ms-2">Online</span>
        @elseif($lead->lead_type == 1)
            <span class="badge bg-warning ms-2">Trực tiếp</span>
        @endif
    </h1>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if($lead->lead_type == 1)
            <p><strong>Mã Khách Hàng:</strong> {{ $lead->customerCode->customer_code ?? 'N/A' }}</p>
            <p><strong>Mã đơn hàng:</strong> {{ $lead->order_code }}</p>
            <p><strong>Ngày tương tác đầu tiên:</strong> {{ $lead->first_interaction_date }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $lead->name }}</p>
            <p>
                <strong>Số điện thoại:</strong> 
                {{ is_array($phones) ? implode(', ', $phones) : $lead->phones->pluck('phone')->implode(', ') ?? '-' }}
            </p>
            <p><strong>Tỉnh/Thành phố:</strong> {{ $lead->province->name ?? '' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $lead->address }}</p>
            <p><strong>Zalo:</strong> {{ $lead->zalo }}</p>
            <p><strong>Phân Loại khách hàng:</strong> {{ $lead->customerType->name ?? '' }}</p>
            <p><strong>Danh mục sản phẩm:</strong> {{ $lead->productCategories->pluck('name')->implode(', ') }}</p>
            <p><strong>Showroom:</strong> {{ $lead->showroom->name ?? '' }}</p>
            <p><strong>Ghi chú sale nhận khách:</strong> {{ $lead->note }}</p>
            <p><strong>Sale nhận KH:</strong> {{ $lead->saleInformation->name ?? '' }}</p>
            <p><strong>Tình trạng KH hiện tại:</strong> {{ $lead->currentStatus->name ?? '' }}</p>
            <p><strong>Giá trị đơn chốt được:</strong> {{ number_format($lead->order_value) }}</p>
            <p><strong>KH đã được hỗ trợ trước qua kênh nào?:</strong> {{ $lead->supportedChannel ? $lead->supportedChannel->name : '' }}</p>
            <p><strong>Chuyển sang TMDT:</strong> {{ $lead->tmdt }}</p>
            @endif
            
            @if($lead->lead_type == 2)
            <p><strong>Mã Khách Hàng:</strong> {{ $lead->customerCode->customer_code ?? 'N/A' }}</p>
            <p><strong>Mã đơn hàng:</strong> {{ $lead->order_code }}</p>
            <p><strong>Ngày tương tác đầu tiên:</strong> {{ $lead->first_interaction_date }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $lead->name }}</p>
            <p>
                <strong>Số điện thoại:</strong> 
                {{ is_array($phones) ? implode(', ', $phones) : $lead->phones->pluck('phone')->implode(', ') ?? '-' }}
            </p>
            <p><strong>Tỉnh/Thành phố:</strong> {{ $lead->province->name ?? '' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $lead->address }}</p>
            <p><strong>Zalo:</strong> {{ $lead->zalo }}</p>
            <p><strong>Phân Loại khách hàng:</strong> {{ $lead->customerType->name ?? '' }}</p>
            <p><strong>Nguồn:</strong> {{ $lead->customerSource->name ?? '' }}</p>
            <p><strong>Danh mục sản phẩm:</strong> {{ $lead->productCategories->pluck('name')->implode(', ') }}</p>
            <p><strong>Tình trạng KH ban đầu:</strong> {{ $lead->firstStatus->name ?? '' }}</p>
            <p><strong>Ghi chú sale nhận khách:</strong> {{ $lead->note }}</p>
            <p><strong>Sale nhận KH:</strong> {{ $lead->saleInformation->name ?? '' }}</p>
            <p><strong>Sale hỗ trợ:</strong> {{ $lead->saleSupport->name ?? '' }}</p>
            <p><strong>Tình trạng KH hiện tại:</strong> {{ $lead->currentStatus->name ?? '' }}</p>
            <p><strong>Giá trị đơn chốt được:</strong> {{ number_format($lead->order_value) }}</p>
            <p><strong>Thông tin trao đổi với KH:</strong> {{ $lead->customer_discussion_details ?? '' }}</p>
            <p><strong>Chuyển sang TMDT:</strong> {{ $lead->tmdt }}</p>
            <hr>
            <h5>Thông tin chăm sóc khách hàng</h5>
            @foreach($lead->leadTakeCares->take(3) as $care)
                <div class="mb-2">
                    <strong>Kế hoạch:</strong> {{ $care->take_care_plan }}<br>
                    <strong>Ngày:</strong> {{ $care->take_care_date }}<br>
                    <strong>Kết quả:</strong> {{ $care->take_care_result }}
                </div>
            @endforeach
            @endif
        </div>
    </div>

    @if($lead->customerCode)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white fw-bold py-3">
            <i class="bi bi-list-stars text-warning me-1"></i> 
            Danh sách tất cả đơn hàng của khách hàng này (Mã khách: {{ $lead->customerCode->customer_code }})
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped mb-0 text-nowrap align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Hành động</th>
                            <th class="text-center">Chỉnh sửa</th> <th>Mã Đơn Hàng</th>
                            <th>Loại Lead</th>
                            <th>Ngày tương tác đầu tiên</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tỉnh/Thành phố</th>
                            <th>Địa chỉ</th>
                            <th>Zalo</th>
                            <th>Phân loại KH</th>
                            <th>Danh mục sản phẩm</th>
                            <th>Showroom / Nguồn</th>
                            <th>Tình trạng KH đầu / Kênh hỗ trợ</th>
                            <th>Ghi chú sale</th>
                            <th>Sale nhận KH</th>
                            <th>Sale hỗ trợ</th>
                            <th>Tình trạng hiện tại</th>
                            <th>Giá trị đơn</th>
                            <th>Chuyển TMDT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lead->customerCode->leads as $allOrder)
                            <tr class="{{ $allOrder->id == $lead->id ? 'table-warning fw-bold' : '' }}">
                                <td class="text-center">
                                    @if($allOrder->id != $lead->id)
                                        <a href="{{ route('leads.show', $allOrder->id) }}" class="btn btn-sm btn-primary py-0 px-2">
                                            Xem
                                        </a>
                                    @else
                                        <span class="badge bg-dark text-white">Đang xem</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('leads.edit', $allOrder->id) }}" class="btn btn-sm btn-warning py-0 px-2">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                </td>

                                <td>{{ $allOrder->order_code }}</td>
                                <td>
                                    @if($allOrder->lead_type == 2)
                                        <span class="badge bg-info text-dark">Online</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Trực tiếp</span>
                                    @endif
                                </td>
                                <td>{{ $allOrder->first_interaction_date }}</td>
                                <td>{{ $allOrder->name }}</td>
                                <td>{{ $allOrder->phones->pluck('phone')->implode(', ') ?: '-' }}</td>
                                <td>{{ $allOrder->province->name ?? '-' }}</td>
                                <td>{{ $allOrder->address ?? '-' }}</td>
                                <td>{{ $allOrder->zalo ?? '-' }}</td>
                                <td>{{ $allOrder->customerType->name ?? '-' }}</td>
                                <td>{{ $allOrder->productCategories->pluck('name')->implode(', ') ?: '-' }}</td>
                                <td>
                                    @if($allOrder->lead_type == 1)
                                        {{ $allOrder->showroom->name ?? '-' }} (SR)
                                    @else
                                        {{ $allOrder->customerSource->name ?? '-' }} (Nguồn)
                                    @endif
                                </td>
                                <td>
                                    @if($allOrder->lead_type == 1)
                                        {{ $allOrder->supportedChannel->name ?? '-' }}
                                    @else
                                        {{ $allOrder->firstStatus->name ?? '-' }}
                                    @endif
                                </td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $allOrder->note ?? '-' }}</td>
                                <td>{{ $allOrder->saleInformation->name ?? '-' }}</td>
                                <td>{{ $allOrder->saleSupport->name ?? '-' }}</td>
                                <td>{{ $allOrder->currentStatus->name ?? '-' }}</td>
                                <td class="text-danger fw-bold">{{ number_format($allOrder->order_value) }} đ</td>
                                <td>{{ $allOrder->tmdt ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="20" class="text-center text-muted p-3">Không có đơn hàng nào khác.</td> </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

{{-- ============================================================
     LỊCH SỬ CHỈNH SỬA LEAD
============================================================ --}}

<!-- <div class="card shadow-sm mb-4">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-clock-history me-2"></i>
            <strong>Lịch sử chỉnh sửa Lead</strong>
        </div>

        <span class="badge bg-light text-dark">
            {{ $auditLogs->count() }} lần chỉnh sửa
        </span>
    </div>

    <div class="card-body">

        @if($auditLogs->count())

            <div class="accordion" id="auditHistoryAccordion">

                @foreach($auditLogs as $index => $audit)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Lấy dữ liệu cũ / mới
                        |--------------------------------------------------------------------------
                        */

                        $oldValues = is_array($audit->old_values)
                            ? $audit->old_values
                            : (json_decode($audit->old_values ?? '{}', true) ?: []);

                        $newValues = is_array($audit->new_values)
                            ? $audit->new_values
                            : (json_decode($audit->new_values ?? '{}', true) ?: []);


                        /*
                        |--------------------------------------------------------------------------
                        | Không hiển thị các field hệ thống
                        |--------------------------------------------------------------------------
                        */

                        $ignoreFields = [
                            'updated_at',
                            'created_at',
                        ];


                        /*
                        |--------------------------------------------------------------------------
                        | Tên hiển thị
                        |--------------------------------------------------------------------------
                        */

                        $fieldLabels = [

                            'customer_id' => 'Mã khách hàng',
                            'order_code' => 'Mã đơn hàng',
                            'first_interaction_date' => 'Ngày tương tác đầu tiên',
                            'name' => 'Tên khách hàng',
                            'phones' => 'Số điện thoại',
                            'address' => 'Địa chỉ',
                            'zalo' => 'Zalo',

                            'province_id' => 'Tỉnh/Thành phố',
                            'customer_type_id' => 'Phân loại khách hàng',
                            'customer_source_id' => 'Nguồn',

                            'note' => 'Ghi chú sale nhận khách',

                            'sale_information_id' => 'Sale nhận KH',
                            'sale_support_id' => 'Sale hỗ trợ',

                            'first_status_id' => 'Tình trạng KH ban đầu',
                            'current_status_id' => 'Tình trạng KH hiện tại',

                            'showroom_id' => 'Showroom',
                            'supported_channel_id' => 'Kênh hỗ trợ',

                            'order_value' => 'Giá trị đơn chốt được',

                            'customer_discussion_details' => 'Thông tin trao đổi với KH',

                            'tmdt' => 'Chuyển sang TMDT',

                            'lead_type' => 'Loại Lead',
                            'old_lead_type' => 'Loại Lead cũ',
                        ];


                        /*
                        |--------------------------------------------------------------------------
                        | Chuẩn hóa giá trị để so sánh
                        |--------------------------------------------------------------------------
                        */

                        $normalizeValue = function ($value) {

                            if (is_array($value)) {

                                return json_encode(
                                    $value,
                                    JSON_UNESCAPED_UNICODE |
                                    JSON_UNESCAPED_SLASHES
                                );
                            }

                            if (is_object($value)) {

                                return json_encode(
                                    $value,
                                    JSON_UNESCAPED_UNICODE |
                                    JSON_UNESCAPED_SLASHES
                                );
                            }

                            return (string) ($value ?? '');
                        };


                        /*
                        |--------------------------------------------------------------------------
                        | Chỉ lấy field thực sự thay đổi
                        |--------------------------------------------------------------------------
                        */

                        $changes = [];


                        /*
                        |--------------------------------------------------------------------------
                        | Duyệt toàn bộ field trong dữ liệu MỚI
                        |--------------------------------------------------------------------------
                        */

                        foreach ($newValues as $field => $newValue) {

                            if (in_array($field, $ignoreFields, true)) {
                                continue;
                            }

                            $oldValue = $oldValues[$field] ?? null;

                            $oldCompare = $normalizeValue($oldValue);
                            $newCompare = $normalizeValue($newValue);


                            /*
                            |--------------------------------------------------------------------------
                            | Chỉ ghi nhận khi khác nhau
                            |--------------------------------------------------------------------------
                            */

                            if ($oldCompare !== $newCompare) {

                                $changes[$field] = [
                                    'old' => $oldValue,
                                    'new' => $newValue,
                                ];
                            }
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Trường hợp field bị XÓA giá trị
                        |
                        | Ví dụ:
                        | old = "Nguyễn Văn A"
                        | new = ""
                        |
                        | Vẫn phải hiển thị.
                        |--------------------------------------------------------------------------
                        */

                        foreach ($oldValues as $field => $oldValue) {

                            if (in_array($field, $ignoreFields, true)) {
                                continue;
                            }

                            /*
                            | Nếu field không tồn tại trong newValues
                            | thì coi như giá trị mới = null
                            */

                            if (!array_key_exists($field, $newValues)) {

                                $newValue = null;

                                $oldCompare = $normalizeValue($oldValue);
                                $newCompare = $normalizeValue($newValue);

                                if ($oldCompare !== $newCompare) {

                                    $changes[$field] = [
                                        'old' => $oldValue,
                                        'new' => $newValue,
                                    ];
                                }
                            }
                        }

                    @endphp


                    {{-- Chỉ hiện lịch sử nếu thật sự có thay đổi --}}

                    @if(count($changes))

                        <div class="accordion-item mb-2 border rounded">

                            <h2 class="accordion-header">

                                <button
                                    class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#audit{{ $audit->id }}"
                                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                >

                                    <div class="w-100">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <i class="bi bi-person-circle me-1"></i>

                                                <strong>
                                                    {{ $audit->user->name ?? 'Không xác định' }}
                                                </strong>

                                                <span class="text-muted ms-2">
                                                    đã chỉnh sửa
                                                </span>

                                                <span class="badge bg-secondary ms-2">
                                                    {{ count($changes) }} trường
                                                </span>

                                            </div>

                                            <div class="text-muted small me-3">

                                                <i class="bi bi-clock me-1"></i>

                                                {{ optional($audit->created_at)->format('d/m/Y H:i:s') }}

                                            </div>

                                        </div>

                                    </div>

                                </button>

                            </h2>


                            <div
                                id="audit{{ $audit->id }}"
                                class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                data-bs-parent="#auditHistoryAccordion"
                            >

                                <div class="accordion-body p-0">

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-hover mb-0 align-middle">

                                            <thead class="table-light">

                                                <tr>

                                                    <th style="width:25%;">
                                                        Trường
                                                    </th>

                                                    <th style="width:37.5%;">
                                                        Giá trị cũ
                                                    </th>

                                                    <th style="width:37.5%;">
                                                        Giá trị mới
                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                @foreach($changes as $field => $change)

                                                    @php

                                                        $label = $fieldLabels[$field]
                                                            ?? ucwords(
                                                                str_replace(
                                                                    '_',
                                                                    ' ',
                                                                    $field
                                                                )
                                                            );


                                                        $old = $change['old'] ?? null;
                                                        $new = $change['new'] ?? null;


                                                        /*
                                                        |--------------------------------------------------------------------------
                                                        | Format giá trị
                                                        |--------------------------------------------------------------------------
                                                        */

                                                        $formatAuditValue = function ($value) {

                                                            if ($value === null || $value === '') {
                                                                return '(trống)';
                                                            }

                                                            if (is_array($value)) {

                                                                if (empty($value)) {
                                                                    return '(trống)';
                                                                }

                                                                return json_encode(
                                                                    $value,
                                                                    JSON_UNESCAPED_UNICODE |
                                                                    JSON_UNESCAPED_SLASHES |
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                            }

                                                            if (is_object($value)) {

                                                                return json_encode(
                                                                    $value,
                                                                    JSON_UNESCAPED_UNICODE |
                                                                    JSON_UNESCAPED_SLASHES |
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                            }

                                                            if (is_bool($value)) {
                                                                return $value ? 'Có' : 'Không';
                                                            }

                                                            return (string) $value;
                                                        };


                                                        $oldFormatted = $formatAuditValue($old);
                                                        $newFormatted = $formatAuditValue($new);

                                                    @endphp


                                                    <tr>

                                                        {{-- FIELD --}}

                                                        <td>

                                                            <strong>
                                                                {{ $label }}
                                                            </strong>

                                                            <div class="small text-muted">
                                                                {{ $field }}
                                                            </div>

                                                        </td>


                                                        {{-- GIÁ TRỊ CŨ --}}

                                                        <td>

                                                            @if($oldFormatted === '(trống)')

                                                                <span class="text-muted fst-italic">
                                                                    (trống)
                                                                </span>

                                                            @else

                                                                <div
                                                                    style="
                                                                        white-space: pre-wrap;
                                                                        word-break: break-word;
                                                                    "
                                                                >
                                                                    {{ $oldFormatted }}
                                                                </div>

                                                            @endif

                                                        </td>


                                                        {{-- GIÁ TRỊ MỚI --}}

                                                        <td>

                                                            @if($newFormatted === '(trống)')

                                                                <span class="text-muted fst-italic">
                                                                    (trống)
                                                                </span>

                                                            @else

                                                                <div
                                                                    style="
                                                                        white-space: pre-wrap;
                                                                        word-break: break-word;
                                                                    "
                                                                >
                                                                    {{ $newFormatted }}
                                                                </div>

                                                            @endif

                                                        </td>

                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

        @else

            <div class="text-center text-muted py-4">

                <i class="bi bi-clock-history fs-2 d-block mb-2"></i>

                Chưa có lịch sử chỉnh sửa.

            </div>

        @endif

    </div>

</div> -->

@php
    /*
    |--------------------------------------------------------------------------
    | FIELD LABELS
    |--------------------------------------------------------------------------
    */

    $fieldLabels = [
        'customer_id'                 => 'ID Khách hàng',
        'order_code'                  => 'Mã đơn hàng',
        'first_interaction_date'      => 'Ngày tương tác đầu',
        'name'                        => 'Tên khách hàng',
        'phones'                      => 'Số Điện Thoại',
        'province_id'                 => 'Tỉnh/Thành phố',
        'address'                     => 'Địa chỉ',
        'zalo'                        => 'Zalo',
        'customer_type_id'            => 'Loại khách hàng',
        'showroom_id'                 => 'Showroom',
        'product_categories_id'       => 'Danh mục sản phẩm',
        'first_customer_status_id'    => 'Tình trạng ban đầu',
        'note'                        => 'Ghi chú',
        'sale_information_id'         => 'Sale nhận KH',
        'sale_support_id'             => 'Sale hỗ trợ',
        'current_customer_status_id'  => 'Tình trạng hiện tại',
        'order_value'                 => 'Giá trị đơn',
        'support_channel_id'          => 'Kênh hỗ trợ',
        'source_id'                   => 'Nguồn',
        'customer_discussion_details' => 'Chi tiết trao đổi',
        'tmdt'                        => 'Chuyển TMDT',
        'lead_type'                   => 'Loại Lead',
        'old_lead_type'               => 'Loại Lead cũ',
        'created_by'                  => 'Người tạo',

        /*
        | Không render trực tiếp field này.
        | Bên dưới sẽ tách thành 3 cột.
        */
        'lead_take_care'              => 'Chăm sóc Lead',
    ];


    $maps = $maps ?? [];


    /*
    |--------------------------------------------------------------------------
    | ACTIVE FILTERS
    |--------------------------------------------------------------------------
    */

    $activeFilters = collect([
        'user_id',
        'event',
        'date_from',
        'date_to',
        'search',
        'source_id',
        'showroom_id',
        'lead_type',
        'customer_type_id',
        'support_channel_id',
        'customer_status_id',
        'product_categories_id',
    ])
        ->filter(fn ($k) => request()->filled($k))
        ->count();


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE AUDIT VALUE
    |--------------------------------------------------------------------------
    */

    $normalizeAuditValue = function ($value) {

        /*
        | JSON string -> array
        */
        if (is_string($value)) {

            $trimmed = trim($value);

            if (
                $trimmed !== '' &&
                (
                    str_starts_with($trimmed, '[') ||
                    str_starts_with($trimmed, '{')
                )
            ) {

                $decoded = json_decode($trimmed, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $value = $decoded;
                }
            }
        }


        /*
        | Object -> array
        */
        if (is_object($value)) {
            $value = (array) $value;
        }


        /*
        | Normalize array
        */
        if (is_array($value)) {

            return collect($value)
                ->map(function ($item) {

                    if (is_string($item)) {

                        $decoded = json_decode($item, true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            $item = $decoded;
                        }
                    }

                    if (is_object($item)) {
                        $item = (array) $item;
                    }

                    if (is_array($item)) {

                        return collect($item)
                            ->sortKeys()
                            ->toArray();
                    }

                    return $item;
                })
                ->values()
                ->toArray();
        }


        /*
        | null và empty string xem như giống nhau
        */
        if ($value === null || $value === '') {
            return null;
        }


        return $value;
    };


    /*
    |--------------------------------------------------------------------------
    | CHECK REAL CHANGE
    |--------------------------------------------------------------------------
    */

    $auditValuesChanged = function ($old, $new) use ($normalizeAuditValue) {

        $old = $normalizeAuditValue($old);
        $new = $normalizeAuditValue($new);

        return $old != $new;
    };


    /*
    |--------------------------------------------------------------------------
    | FORMAT VALUE
    |--------------------------------------------------------------------------
    */

    $formatAuditValue = function ($field, $value) use ($maps) {

        /*
        | Empty
        */
        if (is_null($value) || $value === '') {

            return '<span class="audit-empty-val">—</span>';
        }


        /*
        | Boolean
        */
        if (is_bool($value)) {

            return $value
                ? 'Có'
                : 'Không';
        }


        /*
        |--------------------------------------------------------------------------
        | LEAD TYPE
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $field,
                [
                    'lead_type',
                    'old_lead_type'
                ],
                true
            )
        ) {

            $leadTypeMap = [
                1 => 'Trực tiếp',
                2 => 'Online',
            ];

            return e(
                $leadTypeMap[(int) $value]
                    ?? (string) $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LEAD TAKE CARE
        |--------------------------------------------------------------------------
        |
        | Field này không render trực tiếp.
        | Tuy nhiên vẫn giữ xử lý để tránh lỗi nếu được gọi ở nơi khác.
        |--------------------------------------------------------------------------
        */

        if ($field === 'lead_take_care') {

            return '<span class="text-muted">Chăm sóc Lead</span>';
        }


        /*
        |--------------------------------------------------------------------------
        | PROVINCE
        |--------------------------------------------------------------------------
        */

        if ($field === 'province_id') {

            return e(
                $maps['province_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PHONE
        |--------------------------------------------------------------------------
        */

        if ($field === 'phones') {

            if (is_array($value)) {

                return e(
                    implode(
                        ', ',
                        array_map(
                            fn ($v) => (string) $v,
                            $value
                        )
                    )
                );
            }

            return e((string) $value);
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER TYPE
        |--------------------------------------------------------------------------
        */

        if ($field === 'customer_type_id') {

            return e(
                $maps['customer_type_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SOURCE
        |--------------------------------------------------------------------------
        */

        if ($field === 'source_id') {

            return e(
                $maps['source_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCT CATEGORIES
        |--------------------------------------------------------------------------
        */

        if ($field === 'product_categories_id') {

            $values = is_array($value)
                ? $value
                : [$value];

            $productNames = collect($values)
                ->map(function ($id) use ($maps) {

                    return $maps['product_categories_id'][$id]
                        ?? $id;
                })
                ->filter()
                ->join(', ');

            return e($productNames);
        }


        /*
        |--------------------------------------------------------------------------
        | SHOWROOM
        |--------------------------------------------------------------------------
        */

        if ($field === 'showroom_id') {

            return e(
                $maps['showroom_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER STATUS
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $field,
                [
                    'first_customer_status_id',
                    'current_customer_status_id'
                ],
                true
            )
        ) {

            return e(
                $maps['customer_status_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $field,
                [
                    'sale_information_id',
                    'sale_support_id',
                    'created_by'
                ],
                true
            )
        ) {

            return e(
                $maps['users'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SUPPORT CHANNEL
        |--------------------------------------------------------------------------
        */

        if ($field === 'support_channel_id') {

            return e(
                $maps['support_channel_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER ID
        |--------------------------------------------------------------------------
        */

        if ($field === 'customer_id') {

            return e(
                $maps['customer_id'][$value]
                    ?? $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ORDER VALUE
        |--------------------------------------------------------------------------
        */

        if (
            $field === 'order_value' &&
            is_numeric($value)
        ) {

            return number_format(
                $value,
                0,
                ',',
                '.'
            ) . ' đ';
        }


        /*
        |--------------------------------------------------------------------------
        | ARRAY
        |--------------------------------------------------------------------------
        */

        if (is_array($value)) {

            return e(
                implode(
                    ', ',
                    array_map(
                        function ($item) {

                            if (is_array($item)) {

                                return json_encode(
                                    $item,
                                    JSON_UNESCAPED_UNICODE
                                );
                            }

                            return (string) $item;
                        },
                        $value
                    )
                )
            );
        }


        return e((string) $value);
    };


    /*
    |--------------------------------------------------------------------------
    | CLEAN INLINE
    |--------------------------------------------------------------------------
    */

    $cleanInline = function ($value) {

        if (is_null($value)) {
            return '';
        }


        if (is_array($value)) {

            $value = implode(
                ', ',
                array_map(
                    function ($item) {

                        if (is_array($item)) {

                            return json_encode(
                                $item,
                                JSON_UNESCAPED_UNICODE
                            );
                        }

                        return (string) $item;
                    },
                    $value
                )
            );
        }


        if (is_object($value)) {

            $value = json_encode(
                $value,
                JSON_UNESCAPED_UNICODE
            );
        }


        $value = str_replace(
            [
                '<br>',
                '<br/>',
                '<br />',
                '</p>',
                '</div>',
                '</li>'
            ],
            ' ',
            (string) $value
        );


        $value = strip_tags($value);


        return trim(
            preg_replace(
                '/\s+/',
                ' ',
                $value
            )
        );
    };


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE LEAD TAKE CARE
    |--------------------------------------------------------------------------
    |
    | Hỗ trợ tất cả các trường hợp:
    |
    | 1. Array:
    | [
    |     'take_care_plan'   => '...',
    |     'take_care_date'   => '...',
    |     'take_care_result' => '...'
    | ]
    |
    | 2. JSON:
    | "{\"take_care_plan\":\"...\"...}"
    |
    | 3. Object
    |
    |--------------------------------------------------------------------------
    */

    $normalizeTakeCare = function ($value) {

        /*
        | Null
        */
        if (
            $value === null ||
            $value === ''
        ) {
            return null;
        }


        /*
        | JSON string
        */
        if (is_string($value)) {

            $trimmed = trim($value);

            if ($trimmed !== '') {

                $decoded = json_decode(
                    $trimmed,
                    true
                );

                if (
                    json_last_error() === JSON_ERROR_NONE
                ) {
                    $value = $decoded;
                }
            }
        }


        /*
        | Object -> array
        */
        if (is_object($value)) {
            $value = (array) $value;
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT OBJECT
        |--------------------------------------------------------------------------
        */

        if (is_array($value)) {

            if (
                array_key_exists(
                    'take_care_plan',
                    $value
                )
                ||
                array_key_exists(
                    'take_care_date',
                    $value
                )
                ||
                array_key_exists(
                    'take_care_result',
                    $value
                )
            ) {

                return $value;
            }


            /*
            |--------------------------------------------------------------------------
            | TRƯỜNG HỢP ARRAY NHIỀU RECORD
            |--------------------------------------------------------------------------
            */

            foreach ($value as $item) {

                if (is_string($item)) {

                    $decoded = json_decode(
                        $item,
                        true
                    );

                    if (
                        json_last_error() === JSON_ERROR_NONE
                    ) {
                        $item = $decoded;
                    }
                }


                if (is_object($item)) {
                    $item = (array) $item;
                }


                if (
                    is_array($item)
                    &&
                    (
                        array_key_exists(
                            'take_care_plan',
                            $item
                        )
                        ||
                        array_key_exists(
                            'take_care_date',
                            $item
                        )
                        ||
                        array_key_exists(
                            'take_care_result',
                            $item
                        )
                    )
                ) {

                    return $item;
                }
            }
        }


        return null;
    };


    /*
    |--------------------------------------------------------------------------
    | RENDER NORMAL FIELD
    |--------------------------------------------------------------------------
    */

    $renderNormalField = function (
        $field,
        $hasOld,
        $hasNew,
        $oldValue,
        $newValue
    ) use (
        $cleanInline,
        $formatAuditValue,
        $auditValuesChanged
    ) {

        /*
        | Không có field
        */
        if (
            !$hasOld &&
            !$hasNew
        ) {

            return '
                <span class="text-muted">-</span>
            ';
        }


        /*
        | Check changed
        */
        $changed = $auditValuesChanged(
            $oldValue,
            $newValue
        );


        /*
        |--------------------------------------------------------------------------
        | KHÔNG THAY ĐỔI
        |--------------------------------------------------------------------------
        */

        if (!$changed) {

            $value = $hasNew
                ? $newValue
                : $oldValue;


            $formatted = $cleanInline(
                $formatAuditValue(
                    $field,
                    $value
                )
            );


            return '
                <span
                    class="audit-single-value"
                    style="white-space:nowrap !important;"
                >
                    ' .
                    e(
                        $formatted !== ''
                            ? $formatted
                            : '-'
                    ) .
                '
                </span>
            ';
        }


        /*
        |--------------------------------------------------------------------------
        | CÓ THAY ĐỔI
        |--------------------------------------------------------------------------
        */

        $formattedOld = $hasOld
            ? $cleanInline(
                $formatAuditValue(
                    $field,
                    $oldValue
                )
            )
            : '';


        $formattedNew = $hasNew
            ? $cleanInline(
                $formatAuditValue(
                    $field,
                    $newValue
                )
            )
            : '';


        return '
            <span
                class="audit-field-change"
                style="white-space:nowrap !important;"
            >

                <span class="audit-old-value">
                    ' .
                    e(
                        $formattedOld !== ''
                            ? $formattedOld
                            : '-'
                    ) .
                '
                </span>

                <i class="bi bi-arrow-right audit-arrow"></i>

                <span class="audit-new-value">
                    ' .
                    e(
                        $formattedNew !== ''
                            ? $formattedNew
                            : '-'
                    ) .
                '
                </span>

            </span>
        ';
    };


    /*
    |--------------------------------------------------------------------------
    | RENDER LEAD TAKE CARE FIELD
    |--------------------------------------------------------------------------
    */

    $renderTakeCareField = function (
        $oldTakeCare,
        $newTakeCare,
        $key
    ) use (
        $normalizeTakeCare,
        $cleanInline,
        $auditValuesChanged
    ) {

        /*
        |--------------------------------------------------------------------------
        | NORMALIZE OLD
        |--------------------------------------------------------------------------
        */

        $oldTakeCare = $normalizeTakeCare(
            $oldTakeCare
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALIZE NEW
        |--------------------------------------------------------------------------
        */

        $newTakeCare = $normalizeTakeCare(
            $newTakeCare
        );


        /*
        |--------------------------------------------------------------------------
        | HAS OLD
        |--------------------------------------------------------------------------
        */

        $hasOld = is_array($oldTakeCare)
            &&
            array_key_exists(
                $key,
                $oldTakeCare
            );


        /*
        |--------------------------------------------------------------------------
        | HAS NEW
        |--------------------------------------------------------------------------
        */

        $hasNew = is_array($newTakeCare)
            &&
            array_key_exists(
                $key,
                $newTakeCare
            );


        /*
        |--------------------------------------------------------------------------
        | VALUES
        |--------------------------------------------------------------------------
        */

        $oldValue = $hasOld
            ? $oldTakeCare[$key]
            : null;


        $newValue = $hasNew
            ? $newTakeCare[$key]
            : null;


        /*
        |--------------------------------------------------------------------------
        | FIELD KHÔNG CÓ
        |--------------------------------------------------------------------------
        */

        if (
            !$hasOld &&
            !$hasNew
        ) {

            return [
                'changed' => false,

                'html' => '
                    <span class="text-muted">-</span>
                '
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK CHANGE
        |--------------------------------------------------------------------------
        */

        $changed = $auditValuesChanged(
            $oldValue,
            $newValue
        );


        /*
        |--------------------------------------------------------------------------
        | KHÔNG THAY ĐỔI
        |--------------------------------------------------------------------------
        */

        if (!$changed) {

            $value = $hasNew
                ? $newValue
                : $oldValue;


            $formatted = $cleanInline(
                $value
            );


            return [
                'changed' => false,

                'html' => '
                    <span
                        class="audit-single-value"
                        style="white-space:nowrap !important;"
                    >
                        ' .
                        e(
                            $formatted !== ''
                                ? $formatted
                                : '-'
                        ) .
                    '
                    </span>
                '
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CÓ THAY ĐỔI
        |--------------------------------------------------------------------------
        */

        $formattedOld = $cleanInline(
            $oldValue
        );


        $formattedNew = $cleanInline(
            $newValue
        );


        return [
            'changed' => true,

            'html' => '
                <span
                    class="audit-field-change"
                    style="white-space:nowrap !important;"
                >

                    <span class="audit-old-value">
                        ' .
                        e(
                            $formattedOld !== ''
                                ? $formattedOld
                                : '-'
                        ) .
                    '
                    </span>

                    <i class="bi bi-arrow-right audit-arrow"></i>

                    <span class="audit-new-value">
                        ' .
                        e(
                            $formattedNew !== ''
                                ? $formattedNew
                                : '-'
                        ) .
                    '
                    </span>

                </span>
            '
        ];
    };
@endphp


<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

    /* =========================================================
       AUDIT LOG
    ========================================================= */

    .audit-scope {

        --au-font:
            "Be Vietnam Pro",
            system-ui,
            -apple-system,
            BlinkMacSystemFont,
            "Segoe UI",
            Roboto,
            sans-serif;

        --au-primary: #4f46e5;
        --au-primary-dark: #4338ca;
        --au-primary-light: #eef2ff;
        --au-primary-ring: rgba(79,70,229,.16);

        --au-success: #15803d;
        --au-success-bg: #dcfce7;
        --au-success-border: #bbf7d0;

        --au-danger: #b91c1c;
        --au-danger-bg: #fee2e2;
        --au-danger-border: #fecaca;

        --au-ink: #0f172a;
        --au-text: #334155;
        --au-muted: #64748b;
        --au-soft: #94a3b8;

        --au-surface: #fff;
        --au-line: #e7ebf2;
        --au-line-strong: #d7dee9;

        --au-radius-md: 10px;
        --au-radius-lg: 14px;
        --au-radius-xl: 18px;
        --au-radius-pill: 999px;

        --au-shadow-sm:
            0 1px 3px rgba(15,23,42,.06),
            0 4px 12px rgba(15,23,42,.04);

        --au-shadow-md:
            0 4px 10px rgba(15,23,42,.05),
            0 12px 30px rgba(15,23,42,.07);

        --au-user-w: 250px;
        --au-type-w: 120px;

        font-family: var(--au-font);
        color: var(--au-text);
        font-size: 14px;
        line-height: 1.5;
    }


    .audit-scope *,
    .audit-scope *::before,
    .audit-scope *::after {
        box-sizing: border-box;
    }


    .audit-scope button,
    .audit-scope input,
    .audit-scope select,
    .audit-scope textarea {
        font-family: inherit;
    }


    .audit-scope a {
        text-decoration: none;
    }


    /* =========================================================
       FILTER
    ========================================================= */

    .audit-filter {
        position: relative;
        margin-bottom: 20px;
        background: var(--au-surface);
        border: 1px solid var(--au-line);
        border-radius: var(--au-radius-xl);
        box-shadow: var(--au-shadow-sm);
        overflow: hidden;
    }


    .audit-filter::before {
        content: "";
        display: block;
        height: 3px;
        background:
            linear-gradient(
                90deg,
                #4f46e5 0%,
                #6366f1 50%,
                #818cf8 100%
            );
    }


    .audit-filter-head {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 58px;
        padding: 13px 20px;
        background: #fff;
        border-bottom: 1px solid var(--au-line);
    }


    .audit-filter-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: var(--au-primary-light);
        color: var(--au-primary);
    }


    .audit-filter-title {
        margin: 0;
        color: var(--au-ink);
        font-size: 14px;
        font-weight: 700;
    }


    .audit-filter-badge {
        display: inline-flex;
        align-items: center;
        min-height: 23px;
        padding: 2px 9px;
        border-radius: var(--au-radius-pill);
        background: var(--au-primary-light);
        color: var(--au-primary);
        font-size: 11px;
        font-weight: 700;
    }


    .audit-filter-body {
        padding: 20px;
        background: #fff;
    }


    .audit-filter-grid {
        display: grid;
        grid-template-columns:
            repeat(4, minmax(180px,1fr));
        gap: 16px;
        align-items: end;
    }


    .audit-field-wide {
        grid-column: span 2;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .audit-field-label {
        display: flex;
        align-items: center;
        min-height: 18px;
        margin: 0 0 7px;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
    }


    .audit-field-control {
        position: relative;
    }


    .audit-field-control > i {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }


    .audit-input {
        display: block;
        width: 100%;
        height: 42px;
        padding: 0 13px 0 38px;
        color: var(--au-ink);
        background: #f8fafc;
        border: 1px solid #e5eaf0;
        border-radius: var(--au-radius-md);
        outline: none;
        font-size: 12.5px;
        font-weight: 500;
    }


    .audit-scope select.audit-input {
        padding-right: 36px;
        cursor: pointer;
    }


    .audit-input:focus {
        background: #fff;
        border-color: var(--au-primary);
        box-shadow:
            0 0 0 3px var(--au-primary-ring);
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .audit-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        height: 42px;
    }


    .audit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 42px;
        padding: 0 17px;
        border: 1px solid transparent;
        border-radius: var(--au-radius-md);
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
    }


    .audit-btn-primary {
        color: #fff;
        background:
            linear-gradient(
                135deg,
                #6366f1 0%,
                #4f46e5 100%
            );
        border-color: #4f46e5;
    }


    .audit-btn-ghost {
        color: #475569;
        background: #fff;
        border-color: #d9e0e9;
    }


    /* =========================================================
       TABLE WRAPPER
    ========================================================= */

    .audit-table-wrapper {
        position: relative;
        max-height: 72vh;
        overflow: auto;
        background: #fff;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }


    .audit-table-wrapper::-webkit-scrollbar {
        width: 9px;
        height: 9px;
    }


    .audit-table-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border: 2px solid #fff;
        border-radius: 999px;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .audit-table-horizontal {
        width: max-content !important;
        min-width: 100%;
        margin: 0;
        color: var(--au-text);
        font-size: 11.5px;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: auto;
    }


    .audit-table-horizontal tr {
        display: table-row !important;
    }


    .audit-table-horizontal th,
    .audit-table-horizontal td {
        vertical-align: middle !important;
        background-clip: padding-box;
        white-space: nowrap !important;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .audit-table-horizontal thead th {
        position: sticky;
        top: 0;
        z-index: 3;
        height: 48px;
        padding: 0 14px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid var(--au-line-strong);
        font-size: 10px;
        font-weight: 700;
        text-align: left;
    }


    .audit-field-header {
        min-width: 180px;
        padding: 14px 16px !important;
        text-align: center !important;
        white-space: nowrap !important;
        background: #f8fafc !important;
    }


    .lead-take-care-header {
        min-width: 180px !important;
    }


    /* =========================================================
       STICKY USER
    ========================================================= */

    .audit-table-horizontal .audit-user-col {
        position: sticky !important;
        left: 0;
        width: var(--au-user-w);
        min-width: var(--au-user-w);
        max-width: var(--au-user-w);
        z-index: 8;
        padding: 12px 16px;
        background: #fbfcfe;
        border-right: 1px solid var(--au-line);
    }


    /* =========================================================
       STICKY TYPE
    ========================================================= */

    .audit-table-horizontal .audit-type-col {
        position: sticky !important;
        left: var(--au-user-w);
        width: var(--au-type-w);
        min-width: var(--au-type-w);
        max-width: var(--au-type-w);
        z-index: 8;
        padding: 10px 12px;
        text-align: center;
        background: #fff;
        border-right: 1px solid var(--au-line);
        box-shadow:
            7px 0 12px -10px
            rgba(15,23,42,.35);
    }


    /* =========================================================
       FIELD CELL
    ========================================================= */

    .audit-field-cell {
        min-width: 180px;
        padding: 10px 12px !important;

        background: #fff !important;

        border-bottom: 1px solid #f0f2f5;

        white-space: normal !important;

        vertical-align: middle !important;
    }

    /*
    |--------------------------------------------------------------------------
    | CHỈ Ô THAY ĐỔI MỚI CÓ MÀU
    |--------------------------------------------------------------------------
    */

    .audit-field-cell.is-changed {
        background: #fffdf5 !important;
        border-bottom-color: #fde68a;
    }


    /* =========================================================
       SINGLE VALUE
    ========================================================= */

    .audit-single-value {
        display: block !important;

        width: 100%;
        min-height: 28px;
        max-width: 420px;

        padding: 5px 8px;

        color: #475569;
        background: transparent;
        border: 0;

        font-size: 10.5px;
        font-weight: 500;

        text-align: left !important;

        white-space: normal !important;
        overflow-wrap: anywhere;
        word-break: break-word;
        line-height: 1.5;
    }

    /* =========================================================
       USER
    ========================================================= */

    .audit-user {
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }


    .audit-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex: 0 0 36px;

        width: 36px;
        height: 36px;

        border-radius: 11px;

        font-size: 11px;
        font-weight: 800;
    }


    .audit-avatar.c0 {
        background: #e0e7ff;
        color: #4338ca;
    }


    .audit-avatar.c1 {
        background: #d1fae5;
        color: #047857;
    }


    .audit-avatar.c2 {
        background: #fef3c7;
        color: #b45309;
    }


    .audit-avatar.c3 {
        background: #ffe4e6;
        color: #be123c;
    }


    .audit-avatar.c4 {
        background: #e0f2fe;
        color: #0369a1;
    }


    .audit-avatar.c5 {
        background: #ede9fe;
        color: #6d28d9;
    }


    .audit-user-name {
        color: var(--au-ink);
        font-size: 11.5px;
        font-weight: 700;
        line-height: 1.35;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 160px;
    }


    .audit-user-time {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 3px;
        color: var(--au-muted);
        font-size: 9.5px;
        white-space: nowrap;
    }


    .audit-user-time i {
        color: var(--au-soft);
    }


    /* =========================================================
       EVENT
    ========================================================= */

    .audit-event {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 60px;

        padding: 4px 9px;

        border-radius: var(--au-radius-pill);

        background: #f1f5f9;
        color: #475569;

        font-size: 9px;
        font-weight: 700;

        white-space: nowrap;
    }


    .audit-event.is-created {
        background: #ecfdf5;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }


    .audit-event.is-updated {
        background: #fffbeb;
        color: #a16207;
        border: 1px solid #fde68a;
    }


    .audit-event.is-deleted {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }


    /* =========================================================
       CHANGE
    ========================================================= */

    .audit-field-change {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center;
        gap: 7px;
        white-space: nowrap !important;
    }


    .audit-old-value {
        display: inline-flex;
        align-items: center;

        max-width: 250px;

        padding: 5px 8px;

        overflow: hidden;
        text-overflow: ellipsis;

        white-space: nowrap;

        color: var(--au-danger);
        background: var(--au-danger-bg);
        border: 1px solid var(--au-danger-border);
        border-radius: 6px;

        font-size: 10px;

        text-decoration: line-through;
        text-decoration-color:
            rgba(185,28,28,.35);
    }


    .audit-arrow {
        flex: 0 0 auto;
        color: #94a3b8;
        font-size: 11px;
    }


    .audit-new-value {
        display: inline-flex;
        align-items: center;

        max-width: 250px;

        padding: 5px 8px;

        overflow: hidden;
        text-overflow: ellipsis;

        white-space: nowrap;

        color: var(--au-success);
        background: var(--au-success-bg);
        border: 1px solid var(--au-success-border);
        border-radius: 6px;

        font-size: 10px;
        font-weight: 700;
    }


    .audit-empty-val {
        color: #94a3b8;
    }


    /* =========================================================
       TAKE CARE
    ========================================================= */

    .lead-take-care-plan,
    .lead-take-care-date,
    .lead-take-care-result {
        min-width: 180px !important;
    }


    /* =========================================================
       HOVER
    ========================================================= */

    .audit-table-horizontal tbody tr:hover
    .audit-field-cell:not(.is-changed) {
        background: #fcfcfd !important;
    }


    .audit-table-horizontal tbody tr:hover
    .audit-field-cell.is-changed {
        background: #fffdf5 !important;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .audit-empty {
        padding: 72px 20px;
        text-align: center;
        color: var(--au-muted);
    }


    .audit-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 64px;
        height: 64px;

        margin-bottom: 15px;

        border-radius: 20px;

        background: #f8fafc;
        color: #94a3b8;
    }


    .audit-empty-title {
        margin: 0 0 5px;
        color: var(--au-ink);
        font-size: 13px;
        font-weight: 700;
    }


    .audit-empty-text {
        max-width: 420px;
        margin: 0 auto;
        color: var(--au-muted);
        font-size: 11px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    /* =========================================================
       FILTER TOGGLE
    ========================================================= */

    .audit-filter-head {
        position: relative;
    }

    .audit-filter-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 34px;
        margin-left: auto;
        padding: 7px 12px;
        color: var(--au-primary);
        background: var(--au-primary-light);
        border: 1px solid #c7d2fe;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color .15s ease, border-color .15s ease, color .15s ease;
    }

    .audit-filter-toggle:hover {
        color: #fff;
        background: var(--au-primary);
        border-color: var(--au-primary);
    }

    .audit-filter-toggle i {
        font-size: 12px;
    }

    .audit-filter-body {
        display: block;
        max-height: 1200px;
        opacity: 1;
        overflow: hidden;
        transition: max-height .25s ease, opacity .2s ease, padding .25s ease;
    }

    .audit-filter-body.is-collapsed {
        max-height: 0;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        opacity: 0;
        pointer-events: none;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .audit-filter-grid {
            grid-template-columns:
                repeat(3, minmax(180px,1fr));
        }
    }


    @media (max-width: 991.98px) {

        .audit-filter-grid {
            grid-template-columns:
                repeat(2, minmax(180px,1fr));
        }


        .audit-card-header {
            padding: 14px 16px;
        }


        .audit-filter-body {
            padding: 16px;
        }
    }


    @media (max-width: 767.98px) {

        .audit-scope {
            --au-user-w: 210px;
            --au-type-w: 105px;
        }


        .audit-filter-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }


        .audit-field-wide {
            grid-column: auto;
        }


        .audit-filter-head {
            padding: 12px 14px;
        }


        .audit-filter-body {
            padding: 14px;
        }


        .audit-filter-actions {
            width: 100%;
        }


        .audit-filter-actions .audit-btn {
            flex: 1;
        }


        .audit-table-wrapper {
            max-height: 70vh;
        }


        .audit-table-horizontal {
            min-width: max-content !important;
        }


        .audit-field-header,
        .audit-field-cell {
            min-width: 160px;
        }


        .audit-old-value,
        .audit-new-value {
            max-width: 180px;
        }
    }


    @media (max-width: 575.98px) {

        .audit-scope {
            --au-user-w: 195px;
            --au-type-w: 100px;
        }


        .audit-filter-badge {
            display: none;
        }


        .audit-avatar {
            width: 32px;
            height: 32px;
            flex-basis: 32px;
        }


        .audit-user-name {
            font-size: 10.5px;
            max-width: 120px;
        }


        .audit-user-time {
            font-size: 8.5px;
        }


        .audit-field-header,
        .audit-field-cell {
            min-width: 150px;
        }


        .audit-single-value {
            max-width: 280px;
        }

        
    }

    /* =========================================================
    CANH GIỮA / TRÁI NỘI DUNG AUDIT
    ========================================================= */

    /* Header căn giữa */
    .audit-table-horizontal thead th {
        text-align: center !important;
    }

    /* Các ô mặc định căn giữa */
    .audit-table-horizontal .audit-field-cell {
        text-align: center !important;
        vertical-align: middle !important;
    }

    /* Text dài căn trái */
    .audit-table-horizontal .audit-single-value {
        display: inline-block !important;
        text-align: left !important;
        vertical-align: middle;
    }

    /* Nội dung thay đổi: Old -> New vẫn căn giữa */
    .audit-table-horizontal .audit-field-change {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
    }

    /* Giá trị cũ và mới */
    .audit-table-horizontal .audit-old-value,
    .audit-table-horizontal .audit-new-value {
        text-align: left !important;
    }

    /* Cột người chỉnh sửa */
    .audit-table-horizontal .audit-user-col {
        text-align: left !important;
    }

    /* Tên người dùng */
    .audit-user-name {
        text-align: left !important;
    }

    /* Thời gian */
    .audit-user-time {
        text-align: left !important;
    }

    /* Badge Created / Updated / Deleted */
    .audit-event {
        margin-left: auto;
        margin-right: auto;
    }
  
  
</style>


    <div class="audit-scope">

        {{-- =====================================================
            AUDIT TABLE
        ===================================================== --}}

        <div class="audit-table-wrapper">

            <table class="audit-table audit-table-horizontal">

                {{-- =================================================
                    THEAD
                ================================================= --}}

                <thead>

                    <tr>

                        <th
                            class="audit-user-col"
                            style="white-space:nowrap !important;"
                        >
                            Người sửa
                        </th>


                        <th
                            class="audit-type-col"
                            style="white-space:nowrap !important;"
                        >
                            Thao tác
                        </th>


                        {{-- Field thông thường --}}
                        @foreach($fieldLabels as $field => $label)

                            @if($field !== 'lead_take_care')

                                <th
                                    class="audit-field-header"
                                    style="white-space:nowrap !important;"
                                >
                                    {{ $label }}
                                </th>

                            @endif

                        @endforeach


                        {{-- =================================================
                            LEAD TAKE CARE
                        ================================================= --}}

                        <th
                            class="audit-field-header lead-take-care-header"
                        >
                            Kế hoạch chăm
                        </th>


                        <th
                            class="audit-field-header lead-take-care-header"
                        >
                            Ngày chốt
                        </th>


                        <th
                            class="audit-field-header lead-take-care-header"
                        >
                            Kết quả
                        </th>

                    </tr>

                </thead>


                {{-- =================================================
                    TBODY
                ================================================= --}}

                <tbody>

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | GỘP LOG CÙNG USER + CÙNG PHÚT
                        |--------------------------------------------------------------------------
                        */

                        $groupedAuditLogs = $auditLogs->groupBy(
                            function ($log) {

                                $time = $log->created_at
                                    ? $log->created_at->format('Y-m-d H:i')
                                    : 'no-time';

                                return
                                    ($log->user_id ?? 0)
                                    . '_'
                                    . $time;
                            }
                        );

                    @endphp


                    @forelse(
                        $groupedAuditLogs
                        as $groupKey => $logs
                    )

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | LOG ĐẦU TIÊN
                            |--------------------------------------------------------------------------
                            */

                            $firstLog = $logs->first();


                            /*
                            |--------------------------------------------------------------------------
                            | GỘP OLD / NEW
                            |--------------------------------------------------------------------------
                            */

                            $mergedOldValues = [];

                            $mergedNewValues = [];


                            foreach ($logs as $log) {

                                $old = is_array(
                                    $log->old_values ?? null
                                )
                                    ? $log->old_values
                                    : [];


                                $new = is_array(
                                    $log->new_values ?? null
                                )
                                    ? $log->new_values
                                    : [];


                                $mergedOldValues = array_merge(
                                    $mergedOldValues,
                                    $old
                                );


                                $mergedNewValues = array_merge(
                                    $mergedNewValues,
                                    $new
                                );
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | LEAD TAKE CARE
                            |--------------------------------------------------------------------------
                            */

                            $oldTakeCare =
                                $mergedOldValues['lead_take_care']
                                ?? null;


                            $newTakeCare =
                                $mergedNewValues['lead_take_care']
                                ?? null;


                            /*
                            |--------------------------------------------------------------------------
                            | TÁCH 3 FIELD
                            |--------------------------------------------------------------------------
                            */

                            $takeCarePlan =
                                $renderTakeCareField(
                                    $oldTakeCare,
                                    $newTakeCare,
                                    'take_care_plan'
                                );


                            $takeCareDate =
                                $renderTakeCareField(
                                    $oldTakeCare,
                                    $newTakeCare,
                                    'take_care_date'
                                );


                            $takeCareResult =
                                $renderTakeCareField(
                                    $oldTakeCare,
                                    $newTakeCare,
                                    'take_care_result'
                                );

                        @endphp


                        <tr class="audit-group">

                            {{-- =================================================
                                USER
                            ================================================= --}}

                            <td
                                class="audit-user-col"
                                style="white-space:nowrap !important;"
                            >

                                <div
                                    class="audit-user"
                                >

                                    <span
                                        class="audit-avatar c{{ ($firstLog->user_id ?? 0) % 6 }}"
                                    >
                                        {{
                                            strtoupper(
                                                substr(
                                                    $firstLog->user->name
                                                        ?? 'U',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}
                                    </span>


                                    <div>

                                        <div class="audit-user-name">
                                            {{ $firstLog->user->name ?? 'Không rõ' }}
                                        </div>


                                        <div class="audit-user-time">

                                            <i class="bi bi-calendar3"></i>

                                            {{
                                                $firstLog->created_at
                                                    ? $firstLog->created_at->format('d/m/Y')
                                                    : ''
                                            }}


                                            <i class="bi bi-clock"></i>

                                            {{
                                                $firstLog->created_at
                                                    ? $firstLog->created_at->format('H:i')
                                                    : ''
                                            }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- =================================================
                                EVENT
                            ================================================= --}}

                            <td
                                class="audit-type-col"
                                style="white-space:nowrap !important;"
                            >

                                <span
                                    class="audit-event is-{{ $firstLog->event }}"
                                >
                                    {{ $firstLog->event }}
                                </span>

                            </td>


                            {{-- =================================================
                                FIELD THÔNG THƯỜNG
                            ================================================= --}}

                            @foreach($fieldLabels as $field => $label)

                                @if($field !== 'lead_take_care')

                                    @php

                                        $hasOld =
                                            array_key_exists(
                                                $field,
                                                $mergedOldValues
                                            );


                                        $hasNew =
                                            array_key_exists(
                                                $field,
                                                $mergedNewValues
                                            );


                                        $oldValue =
                                            $hasOld
                                                ? $mergedOldValues[$field]
                                                : null;


                                        $newValue =
                                            $hasNew
                                                ? $mergedNewValues[$field]
                                                : null;


                                        $changed =
                                            (
                                                $hasOld ||
                                                $hasNew
                                            )
                                            &&
                                            $auditValuesChanged(
                                                $oldValue,
                                                $newValue
                                            );

                                    @endphp


                                    <td
                                        class="audit-field-cell {{ $changed ? 'is-changed' : '' }}"
                                        style="
                                            white-space:nowrap !important;
                                            vertical-align:middle;
                                        "
                                    >

                                        {!! $renderNormalField(
                                            $field,
                                            $hasOld,
                                            $hasNew,
                                            $oldValue,
                                            $newValue
                                        ) !!}

                                    </td>

                                @endif

                            @endforeach


                            {{-- =================================================
                                LEAD TAKE CARE
                                KẾ HOẠCH
                            ================================================= --}}

                            <td
                                class="
                                    audit-field-cell
                                    lead-take-care-plan
                                    {{ $takeCarePlan['changed'] ? 'is-changed' : '' }}
                                "
                                style="
                                    white-space:nowrap !important;
                                    vertical-align:middle;
                                "
                            >

                                {!! $takeCarePlan['html'] !!}

                            </td>


                            {{-- =================================================
                                LEAD TAKE CARE
                                NGÀY
                            ================================================= --}}

                            <td
                                class="
                                    audit-field-cell
                                    lead-take-care-date
                                    {{ $takeCareDate['changed'] ? 'is-changed' : '' }}
                                "
                                style="
                                    white-space:nowrap !important;
                                    vertical-align:middle;
                                "
                            >

                                {!! $takeCareDate['html'] !!}

                            </td>


                            {{-- =================================================
                                LEAD TAKE CARE
                                KẾT QUẢ
                            ================================================= --}}

                            <td
                                class="
                                    audit-field-cell
                                    lead-take-care-result
                                    {{ $takeCareResult['changed'] ? 'is-changed' : '' }}
                                "
                                style="
                                    white-space:nowrap !important;
                                    vertical-align:middle;
                                "
                            >

                                {!! $takeCareResult['html'] !!}

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="{{ count($fieldLabels) + 3 }}"
                            >

                                <div class="audit-empty">

                                    <div class="audit-empty-icon">

                                        <i class="bi bi-file-earmark-text fs-1"></i>

                                    </div>


                                    <h4 class="audit-empty-title">
                                        Chưa có dữ liệu audit
                                    </h4>


                                    <p class="audit-empty-text">
                                        Không có thay đổi nào được ghi lại.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>



    </div>



    <div class="mt-2 mb-4">
        
        <a href="{{ route('leads.index', request()->query()) }}">← Quay lại danh sách</a>
        <a href="{{ route('leads.edit', $lead->id) . '?' . http_build_query(request()->query()) }}" class="btn btn-warning ms-1"><i class="bi bi-pencil-square"></i> Sửa đơn hiện tại</a>
        
    </div>
</div>
@endsection