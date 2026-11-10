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
            'totals' => $totals_current,
        ],
        [
            'id' => 2,
            'title' => 'Kỳ 2',
            'from' => request('from_date_2'),
            'to' => request('to_date_2'),
            'totals' => $totals_prev,
        ],
    ];
@endphp

<style>
    .showroom-report {
        --sr-text: #18243a;
        --sr-muted: #526179;
        --sr-border: #e2e8f2;
        --sr-primary: #5146d8;
        max-width: 1800px;
        margin: 0 auto;
        padding: 20px 12px 32px;
        color: var(--sr-text);
    }

    .showroom-report .sr-hero {
        padding: clamp(22px, 4vw, 38px);
        border-radius: 22px;
        background: linear-gradient(115deg, #211c58, #4938bc 75%, #635bff);
        color: #fff;
    }

    .showroom-report .sr-eyebrow {
        color: #e4e0ff;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .showroom-report .sr-hero h1 {
        margin: 6px 0 8px;
        color: #fff;
        font-size: clamp(1.5rem, 4vw, 2.25rem);
        font-weight: 750;
    }

    .showroom-report .sr-hero p {
        margin: 0;
        color: #f0edff;
    }

    .showroom-report .sr-panel {
        min-width: 0;
        border: 1px solid var(--sr-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(24, 36, 58, .06);
    }

    .showroom-report .sr-filter {
        margin: 16px 0;
        padding: 18px;
    }

    .showroom-report .sr-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 750;
    }

    .showroom-report .sr-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
    }

    .showroom-report .sr-filter-grid {
        margin-top: 12px;
    }

    .showroom-report .sr-range {
        min-width: 0;
        margin: 0;
        padding: 12px;
        border: 1px solid var(--sr-border);
        border-radius: 12px;
        background: #fafbff;
    }

    .showroom-report .sr-range legend {
        float: none;
        width: auto;
        margin: 0;
        padding: 0 6px;
        font-size: .88rem;
        font-weight: 750;
    }

    .showroom-report .sr-dates {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .showroom-report .sr-dates label {
        display: block;
        margin-bottom: 4px;
        color: var(--sr-muted);
        font-size: .82rem;
        font-weight: 650;
    }

    .showroom-report .sr-dates input {
        width: 100%;
        min-width: 0;
        border-color: var(--sr-border);
        border-radius: 8px;
    }

    .showroom-report .sr-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }

    .showroom-report .sr-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 39px;
        padding: 8px 14px;
        border: 0;
        border-radius: 9px;
        color: #fff;
        font-weight: 650;
        text-decoration: none;
    }

    .showroom-report .sr-button-filter { background: var(--sr-primary); }
    .showroom-report .sr-button-filter:hover { background: #4035b8; color: #fff; }
    .showroom-report .sr-button-export { background: #087653; }
    .showroom-report .sr-button-export:hover { background: #065b40; color: #fff; }

    .showroom-report .sr-period {
        --sr-accent: #4436ac;
        --sr-soft: #f1eeff;
    }

    .showroom-report .sr-period-2 {
        --sr-accent: #086e61;
        --sr-soft: #e8f7f3;
    }

    .showroom-report .sr-period-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 16px;
    }

    .showroom-report .sr-badge {
        display: inline-block;
        margin-bottom: 7px;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--sr-soft);
        color: var(--sr-accent);
        font-size: .78rem;
        font-weight: 750;
    }

    .showroom-report .sr-muted {
        color: var(--sr-muted);
        font-size: .84rem;
    }

    .showroom-report .sr-table-wrap {
        overflow-x: auto;
        border-radius: 0 0 18px 18px;
    }

    .showroom-report .sr-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: .87rem;
        font-variant-numeric: tabular-nums;
    }

    .showroom-report .sr-table th,
    .showroom-report .sr-table td {
        padding: 11px 13px;
        border-top: 1px solid var(--sr-border);
        vertical-align: middle;
    }

    .showroom-report .sr-table thead th {
        background: #f3f5fa;
        color: #344563;
        font-size: .8rem;
    }

    .showroom-report .sr-table tbody tr > * { background: #fff; }
    .showroom-report .sr-table tbody tr:nth-child(even) > * { background: #fafbff; }
    .showroom-report .sr-table tbody tr:hover > * { background: #f5f6fb; }

    .showroom-report .sr-table .sr-metric {
        position: sticky;
        left: 0;
        z-index: 1;
        min-width: 145px;
        border-right: 1px solid var(--sr-border);
        text-align: left;
    }

    .showroom-report .sr-number {
        min-width: 94px;
        text-align: right;
        white-space: nowrap;
    }

    .showroom-report .sr-table tr > .sr-total {
        background: var(--sr-soft);
        color: var(--sr-accent);
        font-weight: 750;
    }

    .showroom-report .sr-empty {
        padding: 24px;
        border-top: 1px solid var(--sr-border);
        color: var(--sr-muted);
        text-align: center;
    }

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
        .showroom-report .sr-dates {
            grid-template-columns: minmax(0, 1fr);
        }
    }
</style>

<div class="showroom-report">
    @if(session('success'))
        <div class="alert alert-success" role="status">
            <i class="bi bi-check-circle" aria-hidden="true"></i>
            {{ session('success') }}
        </div>
    @endif

    <header class="sr-hero">
        <div class="sr-eyebrow">Báo cáo bán hàng</div>
        <h1>Báo cáo Showroom</h1>
        <p>Đối chiếu các chỉ tiêu của từng showroom qua hai khoảng thời gian.</p>
    </header>

    <form method="GET" class="sr-panel sr-filter">
        <h2 class="sr-title">Chọn khoảng thời gian</h2>

        <div class="sr-grid sr-filter-grid">
            @foreach($periods as $period)
                <fieldset class="sr-range">
                    <legend>{{ $period['title'] }}</legend>

                    <div class="sr-dates">
                        <div>
                            <label for="sr-from-{{ $period['id'] }}">Từ ngày</label>
                            <input
                                type="date"
                                id="sr-from-{{ $period['id'] }}"
                                name="from_date_{{ $period['id'] }}"
                                value="{{ $period['from'] }}"
                                class="form-control"
                            >
                        </div>

                        <div>
                            <label for="sr-to-{{ $period['id'] }}">Đến ngày</label>
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
            <button type="submit" class="sr-button sr-button-filter">
                <i class="bi bi-funnel" aria-hidden="true"></i>
                Lọc báo cáo
            </button>

            <a
                href="{{ route('report_showroom.export', request()->query()) }}"
                class="sr-button sr-button-export"
            >
                <i class="bi bi-file-earmark-excel" aria-hidden="true"></i>
                Xuất Excel
            </a>
        </div>
    </form>

    <div class="sr-grid sr-results">
        @foreach($periods as $period)
            <section
                class="sr-panel sr-period sr-period-{{ $period['id'] }}"
                aria-labelledby="sr-title-{{ $period['id'] }}"
            >
                <div class="sr-period-head">
                    <div>
                        <span class="sr-badge">{{ $period['title'] }}</span>

                        <h2 id="sr-title-{{ $period['id'] }}" class="sr-title">
                            Chi tiết theo showroom
                        </h2>
                    </div>

                    <div class="sr-muted">
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
                </div>

                <div
                    class="sr-table-wrap"
                    role="region"
                    aria-label="Bảng showroom {{ $period['title'] }}"
                    tabindex="0"
                >
                    <table class="sr-table">
                        <thead>
                            <tr>
                                <th scope="col" class="sr-metric">Chỉ tiêu</th>

                                @foreach($showroomList as $showroom)
                                    <th scope="col" class="sr-number">
                                        {{ $showroom->name }}
                                    </th>
                                @endforeach

                                <th scope="col" class="sr-number sr-total">Tổng</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($metrics as $label => $key)
                                @php $sum = 0; @endphp

                                <tr>
                                    <th scope="row" class="sr-metric">{{ $label }}</th>

                                    @foreach($showroomList as $showroom)
                                        @php
                                            $value = $period['totals'][$showroom->id][$key] ?? 0;
                                            $sum += $value;
                                        @endphp

                                        <td class="sr-number">
                                            {{ number_format($value, 0, ',', '.') }}
                                        </td>
                                    @endforeach

                                    <td class="sr-number sr-total">
                                        {{ number_format($sum, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $showroomList->count() + 2 }}" class="sr-empty">
                                        Chưa có chỉ tiêu báo cáo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @endforeach
    </div>
</div>
@endsection