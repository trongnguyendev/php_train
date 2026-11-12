@extends('layouts.app')

@section('content')
@php
    $columns = [
        'total_customers'     => 'Tổng khách hàng',
        'total_new_customers' => 'Khách hàng mới',
        'total_old_customers' => 'Khách hàng cũ',
        'total_new_potential' => 'Tiềm năng mới',
        'total_old_potential' => 'Tiềm năng cũ',
        'total_potential'     => 'Tổng KH tiềm năng',
        'total_care'          => 'KH quan tâm còn lại',
        'total_new_locked'    => 'KH mới đã chốt',
        'total_old_locked'    => 'KH cũ đã chốt',
        'total_value'         => 'DS chốt liền',
    ];

    $periods = [
        [
            'id' => 1,
            'title' => 'Kỳ 1',
            'from' => $from_date_1,
            'to' => $to_date_1,
            'rows' => collect($data),
        ],
        [
            'id' => 2,
            'title' => 'Kỳ 2',
            'from' => $from_date_2,
            'to' => $to_date_2,
            'rows' => collect($data_prev),
        ],
    ];
@endphp

<style>
    .monthly-report {
        --mr-primary: #5146d8;
        --mr-text: #18243a;
        --mr-muted: #526179;
        --mr-border: #e3e9f3;
        max-width: 1800px;
        margin: 0 auto;
        padding: 20px 12px 32px;
        color: var(--mr-text);
    }

    .monthly-report .mr-hero {
        padding: clamp(22px, 4vw, 38px);
        border-radius: 22px;
        background: linear-gradient(115deg, #211c58, #4938bc 75%, #635bff);
        color: #fff;
    }

    .monthly-report .mr-eyebrow {
        color: #e4e0ff;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .monthly-report .mr-hero h1 {
        margin: 6px 0 8px;
        color: #fff;
        font-size: clamp(1.5rem, 4vw, 2.25rem);
        font-weight: 750;
    }

    .monthly-report .mr-hero p {
        margin: 0;
        color: #f0edff;
    }

    .monthly-report .mr-panel {
        min-width: 0;
        border: 1px solid var(--mr-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(24, 36, 58, .06);
    }

    .monthly-report .mr-filter {
        margin: 16px 0;
        padding: 18px;
    }

    .monthly-report .mr-filter-title,
    .monthly-report .mr-result-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 750;
    }

    .monthly-report .mr-filter-grid,
    .monthly-report .mr-results {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
    }

    .monthly-report .mr-filter-grid {
        margin-top: 14px;
    }

    .monthly-report .mr-range {
        min-width: 0;
        margin: 0;
        padding: 12px;
        border: 1px solid var(--mr-border);
        border-radius: 12px;
        background: #fafbff;
    }

    .monthly-report .mr-range legend {
        float: none;
        width: auto;
        margin: 0;
        padding: 0 6px;
        font-size: .9rem;
        font-weight: 700;
    }

    .monthly-report .mr-dates,
    .monthly-report .mr-metrics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .monthly-report .mr-dates label {
        display: block;
        margin-bottom: 4px;
        color: var(--mr-muted);
        font-size: .82rem;
        font-weight: 650;
    }

    .monthly-report .mr-dates input {
        min-width: 0;
        border-color: var(--mr-border);
        border-radius: 8px;
    }

    .monthly-report .mr-sales {
        margin-top: 12px;
    }

    .monthly-report .mr-sale-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        max-height: 180px;
        overflow-y: auto;
    }

    .monthly-report .mr-sale-option {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin: 0;
        cursor: pointer;
    }

    .monthly-report .mr-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }

    .monthly-report .mr-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 39px;
        padding: 8px 14px;
        border: 0;
        border-radius: 9px;
        color: #fff;
        font-weight: 650;
    }

    .monthly-report .mr-button-filter { background: var(--mr-primary); }
    .monthly-report .mr-button-filter:hover { background: #4035b8; }
    .monthly-report .mr-button-export { background: #087653; }
    .monthly-report .mr-button-export:hover { background: #065b40; }

    .monthly-report .mr-result-head {
        padding: 16px;
    }

    .monthly-report .mr-period {
        --mr-accent: #4436ac;
        --mr-soft: #f1eeff;
    }

    .monthly-report .mr-period-2 {
        --mr-accent: #086e61;
        --mr-soft: #e8f7f3;
    }

    .monthly-report .mr-badge {
        display: inline-block;
        margin-bottom: 8px;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--mr-soft);
        color: var(--mr-accent);
        font-size: .78rem;
        font-weight: 750;
    }

    .monthly-report .mr-muted {
        color: var(--mr-muted);
        font-size: .84rem;
    }

    .monthly-report .mr-metrics {
        margin-top: 12px;
    }

    .monthly-report .mr-metric {
        min-width: 0;
        padding: 10px 12px;
        border-radius: 10px;
        background: var(--mr-soft);
    }

    .monthly-report .mr-metric strong {
        display: block;
        color: var(--mr-accent);
        font-size: clamp(1rem, 2vw, 1.3rem);
        font-variant-numeric: tabular-nums;
        overflow-wrap: anywhere;
    }

    .monthly-report .mr-table-wrap {
        overflow-x: auto;
        border-radius: 0 0 18px 18px;
    }

    .monthly-report .mr-table {
        width: 100%;
        min-width: 1040px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: .87rem;
        font-variant-numeric: tabular-nums;
    }

    .monthly-report .mr-table th,
    .monthly-report .mr-table td {
        padding: 11px 12px;
        border-top: 1px solid var(--mr-border);
        vertical-align: middle;
    }

    .monthly-report .mr-table thead th {
        background: #f2f4fa;
        color: #344563;
        font-size: .78rem;
    }

    .monthly-report .mr-table tbody tr > * { background: #fff; }
    .monthly-report .mr-table tbody tr:nth-child(even) > * { background: #f9faff; }
    .monthly-report .mr-table tbody tr:hover > * { background: var(--mr-soft); }

    .monthly-report .mr-name {
        position: sticky;
        left: 0;
        z-index: 1;
        width: 155px;
        min-width: 155px;
        border-right: 1px solid var(--mr-border);
        text-align: left;
    }

    .monthly-report .mr-number { text-align: right; }
    .monthly-report td.mr-number { white-space: nowrap; }

    .monthly-report .mr-revenue {
        color: #087653;
        font-weight: 750;
    }

    .monthly-report .mr-empty {
        padding: 24px;
        border-top: 1px solid var(--mr-border);
        color: var(--mr-muted);
        text-align: center;
    }

    @media (min-width: 768px) {
        .monthly-report .mr-filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1280px) {
        .monthly-report .mr-results {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }
    }

    @media (max-width: 440px) {
        .monthly-report .mr-dates {
            grid-template-columns: minmax(0, 1fr);
        }
    }
</style>

<div class="monthly-report">
    @if(session('success'))
        <div class="alert alert-success" role="status">
            <i class="bi bi-check-circle" aria-hidden="true"></i>
            {{ session('success') }}
        </div>
    @endif

    <header class="mr-hero">
        <div class="mr-eyebrow">Báo cáo bán hàng</div>
        <h1>So sánh hai kỳ báo cáo</h1>
        <p>Theo dõi khách hàng, tiềm năng và doanh số chốt theo từng Sale.</p>
    </header>

    <form method="GET" class="mr-panel mr-filter">
        <h2 class="mr-filter-title">Lọc báo cáo theo ngày và Sale</h2>

        <fieldset class="mr-range mr-sales">
            <legend>Chọn nhân viên Sale</legend>

            <div class="mr-sale-list">
                @forelse ($sales as $sale)
                    <label class="mr-sale-option">
                        <input
                            type="checkbox"
                            name="sale_ids[]"
                            value="{{ $sale->id }}"
                            @checked(in_array((int) $sale->id, $sale_ids, true))
                        >
                        <span>{{ $sale->name }}</span>
                    </label>
                @empty
                    <span>Chưa có tài khoản nhân viên.</span>
                @endforelse
            </div>

            <p class="mr-muted mb-0 mt-2">Bỏ tích tất cả để xem toàn bộ Sale.</p>

            @error('sale_ids')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            @error('sale_ids.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </fieldset>

        <div class="mr-filter-grid">
            @foreach($periods as $period)
                <fieldset class="mr-range">
                    <legend>{{ $period['title'] }}</legend>

                    <div class="mr-dates">
                        <div>
                            <label for="mr-from-{{ $period['id'] }}">Từ ngày</label>
                            <input
                                type="date"
                                id="mr-from-{{ $period['id'] }}"
                                name="from_date_{{ $period['id'] }}"
                                value="{{ $period['from'] }}"
                                class="form-control"
                            >
                        </div>

                        <div>
                            <label for="mr-to-{{ $period['id'] }}">Đến ngày</label>
                            <input
                                type="date"
                                id="mr-to-{{ $period['id'] }}"
                                name="to_date_{{ $period['id'] }}"
                                value="{{ $period['to'] }}"
                                class="form-control"
                            >
                        </div>
                    </div>
                </fieldset>
            @endforeach
        </div>

        <div class="mr-actions">
            <button type="submit" class="mr-button mr-button-filter">
                <i class="bi bi-funnel" aria-hidden="true"></i>
                Lọc báo cáo
            </button>

            <button
                type="submit"
                formaction="{{ route('report.month.export') }}"
                class="mr-button mr-button-export"
            >
                <i class="bi bi-file-earmark-excel" aria-hidden="true"></i>
                Xuất Excel
            </button>
        </div>
    </form>

    <div class="mr-results">
        @foreach($periods as $period)
            <section
                class="mr-panel mr-period mr-period-{{ $period['id'] }}"
                aria-labelledby="mr-title-{{ $period['id'] }}"
            >
                <div class="mr-result-head">
                    <span class="mr-badge">{{ $period['title'] }}</span>

                    <h2 id="mr-title-{{ $period['id'] }}" class="mr-result-title">
                        Chi tiết theo Sale
                    </h2>

                    <div class="mr-muted mt-1">
                        @if($period['from'] && $period['to'])
                            {{ \Carbon\Carbon::parse($period['from'])->format('d/m/Y') }}
                            –
                            {{ \Carbon\Carbon::parse($period['to'])->format('d/m/Y') }}
                        @elseif($period['from'])
                            Từ {{ \Carbon\Carbon::parse($period['from'])->format('d/m/Y') }}
                        @elseif($period['to'])
                            Đến {{ \Carbon\Carbon::parse($period['to'])->format('d/m/Y') }}
                        @else
                            Khoảng ngày mặc định
                        @endif
                    </div>

                    @if($period['rows']->isNotEmpty())
                        <div class="mr-metrics">
                            <div class="mr-metric">
                                <div class="mr-muted">Khách hàng theo Sale</div>
                                <strong>{{ number_format($period['rows']->sum('total_customers')) }}</strong>
                            </div>

                            <div class="mr-metric">
                                <div class="mr-muted">Doanh số chốt liền</div>
                                <strong>{{ number_format($period['rows']->sum('total_value')) }} ₫</strong>
                            </div>
                        </div>
                    @endif
                </div>

                @if($period['rows']->isEmpty())
                    <div class="mr-empty">Chưa có dữ liệu cho kỳ này.</div>
                @else
                    <div
                        class="mr-table-wrap"
                        role="region"
                        aria-label="Bảng chi tiết {{ $period['title'] }}"
                        tabindex="0"
                    >
                        <table class="mr-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="mr-name">Tên Sale</th>

                                    @foreach($columns as $label)
                                        <th scope="col" class="mr-number">{{ $label }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($period['rows'] as $item)
                                    <tr>
                                        <th scope="row" class="mr-name">{{ $item->sale_name }}</th>

                                        @foreach($columns as $key => $label)
                                            <td class="mr-number {{ $key === 'total_value' ? 'mr-revenue' : '' }}">
                                                {{ number_format($item->{$key} ?? 0) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        @endforeach
    </div>
</div>
@endsection