
@extends('layouts.app')

@section('content')
@php
    $showroomList = collect($showrooms);

    $periods = [
        [
            'id' => 1,
            'title' => 'Kỳ 1',
            'from' => request('from_date_1'),
            'to' => request('to_date_1'),
            'totals' => $totals_current ?? [],
        ],
        [
            'id' => 2,
            'title' => 'Kỳ 2',
            'from' => request('from_date_2'),
            'to' => request('to_date_2'),
            'totals' => $totals_prev ?? [],
        ],
    ];

    // Các chỉ tiêu doanh số
    $moneyMetrics = [
        'sr_total_new_closed',
        'sr_total_old_closed',
        'sr_total_sale_closed',
    ];

    // Định dạng số
    $formatValue = function ($value, $key) use ($moneyMetrics) {
        $formatted = number_format((float) $value, 0, ',', '.');

        return in_array($key, $moneyMetrics)
            ? $formatted . ' đ'
            : $formatted;
    };

    // Định dạng ngày
    $formatDate = function ($date) {
        return $date
            ? \Carbon\Carbon::parse($date)->format('d/m/Y')
            : null;
    };
@endphp

<style>
    .showroom-report {
        --sr-text: #18243a;
        --sr-muted: #64748b;
        --sr-border: #e2e8f0;
        --sr-primary: #5146d8;

        max-width: 1800px;
        margin: auto;
        padding: 20px 12px 35px;
        color: var(--sr-text);
    }

    /* HEADER */

    .showroom-report .sr-hero {
        padding: 30px;
        border-radius: 18px;
        background: linear-gradient(115deg, #211c58, #4938bc 75%, #635bff);
        color: #fff;
    }

    .showroom-report .sr-eyebrow {
        color: #dcd6ff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .showroom-report .sr-hero h1 {
        margin: 8px 0;
        color: #fff;
        font-size: clamp(24px, 4vw, 34px);
        font-weight: 800;
    }

    .showroom-report .sr-hero p {
        margin: 0;
        color: #e9e6ff;
        font-size: 14px;
    }

    /* PANEL */

    .showroom-report .sr-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--sr-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 15px rgba(24, 36, 58, .05);
    }

    .showroom-report .sr-filter {
        margin: 18px 0;
        padding: 20px;
    }

    .showroom-report .sr-title {
        margin: 0;
        font-size: 17px;
        font-weight: 750;
    }

    /* FILTER */

    .showroom-report .sr-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 16px;
    }

    .showroom-report .sr-filter-grid {
        margin-top: 15px;
    }

    .showroom-report .sr-range {
        min-width: 0;
        margin: 0;
        padding: 15px;
        border: 1px solid var(--sr-border);
        border-radius: 12px;
        background: #f8f9fd;
    }

    .showroom-report .sr-range legend {
        float: none;
        width: auto;
        margin: 0;
        padding: 0 6px;
        font-size: 14px;
        font-weight: 750;
    }

    .showroom-report .sr-dates {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .showroom-report .sr-dates label {
        display: block;
        margin-bottom: 6px;
        color: var(--sr-muted);
        font-size: 13px;
        font-weight: 600;
    }

    .showroom-report .sr-dates input {
        width: 100%;
        min-width: 0;
        min-height: 40px;
        border: 1px solid var(--sr-border);
        border-radius: 8px;
    }

    /* BUTTON */

    .showroom-report .sr-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }

    .showroom-report .sr-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 9px 16px;
        border: 0;
        border-radius: 9px;
        color: #fff;
        font-size: 14px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .showroom-report .sr-button-filter {
        background: #5146d8;
    }

    .showroom-report .sr-button-filter:hover {
        background: #4035b8;
        color: #fff;
    }

    .showroom-report .sr-button-export {
        background: #087653;
    }

    .showroom-report .sr-button-export:hover {
        background: #065b40;
        color: #fff;
    }

    /* PERIOD */

    .showroom-report .sr-period {
        --sr-accent: #4436ac;
        --sr-soft: #f1eeff;
    }

    .showroom-report .sr-period-2 {
        --sr-accent: #087653;
        --sr-soft: #e8f7f0;
    }

    .showroom-report .sr-period-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 18px;
    }

    .showroom-report .sr-badge {
        display: inline-block;
        margin-bottom: 7px;
        padding: 5px 12px;
        border-radius: 20px;
        background: var(--sr-soft);
        color: var(--sr-accent);
        font-size: 12px;
        font-weight: 800;
    }

    .showroom-report .sr-muted {
        color: var(--sr-muted);
        font-size: 13px;
    }

    .showroom-report .sr-period-date {
        padding: 7px 11px;
        border-radius: 8px;
        background: #f5f6fa;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
    }

    /* TABLE */

    .showroom-report .sr-table-wrap {
        width: 100%;
        overflow-x: auto;
        overscroll-behavior-x: contain;
    }

    .showroom-report .sr-table {
        width: 100%;
        min-width: 650px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
        font-variant-numeric: tabular-nums;
    }

    .showroom-report .sr-table th,
    .showroom-report .sr-table td {
        padding: 12px 13px;
        border-top: 1px solid var(--sr-border);
        vertical-align: middle;
    }

    .showroom-report .sr-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f1f3f9;
        color: #344563;
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .showroom-report .sr-table tbody tr > * {
        background: #fff;
    }

    .showroom-report .sr-table tbody tr:nth-child(even) > * {
        background: #fafbfe;
    }

    .showroom-report .sr-table tbody tr:hover > * {
        background: #f1f5ff;
    }

    .showroom-report .sr-table .sr-metric {
        position: sticky;
        left: 0;
        z-index: 1;
        min-width: 175px;
        border-right: 1px solid var(--sr-border);
        text-align: left;
        font-weight: 650;
        white-space: normal;
    }

    .showroom-report .sr-table thead .sr-metric {
        z-index: 3;
        background: #e9ecf5;
    }

    .showroom-report .sr-number {
        min-width: 110px;
        text-align: right;
        white-space: nowrap;
    }

    .showroom-report .sr-table tr > .sr-total {
        background: var(--sr-soft) !important;
        color: var(--sr-accent);
        font-weight: 800;
    }

    /* EMPTY */

    .showroom-report .sr-empty {
        padding: 25px;
        color: var(--sr-muted);
        text-align: center;
    }

    .showroom-report .sr-empty-showroom {
        padding: 35px;
        color: var(--sr-muted);
        text-align: center;
    }

    /* RESPONSIVE */

    @media (min-width: 768px) {
        .showroom-report .sr-filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1280px) {
        .showroom-report .sr-results {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }
    }

    @media (max-width: 480px) {
        .showroom-report {
            padding: 12px 8px 25px;
        }

        .showroom-report .sr-hero {
            padding: 22px 18px;
        }

        .showroom-report .sr-filter {
            padding: 14px;
        }

        .showroom-report .sr-dates {
            grid-template-columns: 1fr;
        }

        .showroom-report .sr-button {
            flex: 1;
        }
    }
</style>

<div class="showroom-report">

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success" role="status">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <header class="sr-hero">
        <div class="sr-eyebrow">
            <i class="bi bi-bar-chart-line me-1"></i>
            Báo cáo bán hàng trực tiếp
        </div>

        <h1>Báo cáo Showroom</h1>

        <p>
            Thống kê khách hàng, tiềm năng, chốt đơn và doanh số
            theo từng showroom.
        </p>
    </header>

    {{-- BỘ LỌC --}}
    <form method="GET"
          action="{{ url()->current() }}"
          class="sr-panel sr-filter">

        <h2 class="sr-title">
            <i class="bi bi-calendar-range me-2 text-primary"></i>
            Chọn khoảng thời gian đối chiếu
        </h2>

        <div class="sr-grid sr-filter-grid">

            @foreach($periods as $period)

                <fieldset class="sr-range">

                    <legend>
                        <i class="bi bi-calendar-check me-1"></i>
                        {{ $period['title'] }}
                    </legend>

                    <div class="sr-dates">

                        <div>
                            <label for="sr-from-{{ $period['id'] }}">
                                Từ ngày
                            </label>

                            <input
                                type="date"
                                id="sr-from-{{ $period['id'] }}"
                                name="from_date_{{ $period['id'] }}"
                                value="{{ $period['from'] }}"
                                class="form-control"
                            >
                        </div>

                        <div>
                            <label for="sr-to-{{ $period['id'] }}">
                                Đến ngày
                            </label>

                            <input
                                type="date"
                                id="sr-to-{{ $period['id'] }}"
                                name="to_date_{{ $period['id'] }}"
                                value="{{ $period['to'] }}"
                                class="form-control"
                            >
                        </div>

                    </div>

                </fieldset>

            @endforeach

        </div>

        <div class="sr-actions">

            <button type="submit"
                    class="sr-button sr-button-filter">

                <i class="bi bi-funnel"></i>
                Lọc báo cáo

            </button>

            <a href="{{ route('report_showroom.export', request()->query()) }}"
               class="sr-button sr-button-export">

                <i class="bi bi-file-earmark-excel"></i>
                Xuất Excel

            </a>

        </div>
    </form>

    {{-- KẾT QUẢ --}}
    <div class="sr-grid sr-results">

        @foreach($periods as $period)

            <section
                class="sr-panel sr-period sr-period-{{ $period['id'] }}"
                aria-labelledby="sr-title-{{ $period['id'] }}"
            >

                {{-- TIÊU ĐỀ KỲ --}}
                <div class="sr-period-head">

                    <div>

                        <span class="sr-badge">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $period['title'] }}
                        </span>

                        <h2 id="sr-title-{{ $period['id'] }}"
                            class="sr-title">

                            Chi tiết theo showroom

                        </h2>

                    </div>

                    <div class="sr-period-date">

                        @if($period['from'] && $period['to'])

                            {{ $formatDate($period['from']) }}
                            –
                            {{ $formatDate($period['to']) }}

                        @elseif($period['from'])

                            Từ {{ $formatDate($period['from']) }}

                        @elseif($period['to'])

                            Đến {{ $formatDate($period['to']) }}

                        @else

                            Khoảng ngày mặc định

                        @endif

                    </div>

                </div>

                {{-- BẢNG DỮ LIỆU --}}
                @if($showroomList->isNotEmpty())

                    <div
                        class="sr-table-wrap"
                        role="region"
                        aria-label="Bảng báo cáo {{ $period['title'] }}"
                        tabindex="0"
                    >

                        <table class="sr-table">

                            <thead>

                                <tr>

                                    <th scope="col" class="sr-metric">
                                        Chỉ tiêu
                                    </th>

                                    @foreach($showroomList as $showroom)

                                        <th scope="col" class="sr-number">
                                            {{ $showroom->name }}
                                        </th>

                                    @endforeach

                                    <th scope="col"
                                        class="sr-number sr-total">

                                        TỔNG

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($metrics as $label => $key)

                                    @php
                                        $sum = 0;
                                    @endphp

                                    <tr>

                                        <th scope="row" class="sr-metric">

                                            {{ $label }}

                                        </th>

                                        @foreach($showroomList as $showroom)

                                            @php
                                                $value = (float) (
                                                    $period['totals'][$showroom->id][$key] ?? 0
                                                );

                                                $sum += $value;
                                            @endphp

                                            <td class="sr-number">

                                                {{ $formatValue($value, $key) }}

                                            </td>

                                        @endforeach

                                        <td class="sr-number sr-total">

                                            {{ $formatValue($sum, $key) }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="{{ $showroomList->count() + 2 }}"
                                            class="sr-empty">

                                            <i class="bi bi-inbox me-1"></i>
                                            Chưa có chỉ tiêu báo cáo.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="sr-empty-showroom">

                        <i class="bi bi-shop fs-3 d-block mb-2"></i>

                        Chưa có showroom để hiển thị.

                    </div>

                @endif

            </section>

        @endforeach

    </div>

</div>

@endsection
