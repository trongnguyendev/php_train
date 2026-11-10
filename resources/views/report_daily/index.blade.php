@extends('layouts.app')

@section('content')
@php
    $reportDate = \Carbon\Carbon::parse(
        request('date') ?: ($date ?? now()->toDateString())
    )->toDateString();

    $reportRows = collect($data);

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
@endphp

<style>
    .daily-report {
        --dr-primary: #5148d8;
        --dr-border: #e2e8f2;
        --dr-muted: #586780;
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px 12px 32px;
        color: #18243a;
    }

    .daily-report .dr-hero {
        padding: clamp(22px, 4vw, 36px);
        border-radius: 20px;
        background: linear-gradient(115deg, #211c58, #4938bc 75%, #635bff);
        color: #fff;
    }

    .daily-report .dr-hero h1 {
        margin: 6px 0;
        color: #fff;
        font-size: clamp(1.5rem, 4vw, 2.2rem);
        font-weight: 750;
    }

    .daily-report .dr-eyebrow {
        color: #e3dfff;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .daily-report .dr-panel {
        min-width: 0;
        margin-top: 16px;
        border: 1px solid var(--dr-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(24, 36, 58, .06);
    }

    .daily-report .dr-toolbar,
    .daily-report .dr-panel-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px;
    }

    .daily-report .dr-toolbar {
        align-items: flex-end;
    }

    .daily-report .dr-date-form,
    .daily-report .dr-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px;
        margin: 0;
    }

    .daily-report .dr-subtitle {
        margin: 0 0 4px;
        font-size: 1rem;
        font-weight: 750;
    }

    .daily-report .dr-muted {
        color: var(--dr-muted);
        font-size: .85rem;
    }

    .daily-report .dr-count {
        padding: 5px 10px;
        border-radius: 999px;
        background: #eeedff;
        color: #4438ad;
        font-size: .8rem;
        font-weight: 700;
    }

    .daily-report .dr-sales {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 180px), 1fr));
        gap: 8px;
        max-height: 240px;
        overflow: auto;
        padding: 0 20px 18px;
    }

    .daily-report .dr-sale {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
        margin: 0;
        padding: 9px 11px;
        border: 1px solid var(--dr-border);
        border-radius: 9px;
        cursor: pointer;
        overflow-wrap: anywhere;
    }

    .daily-report .dr-sale:hover,
    .daily-report .dr-sale.is-selected {
        border-color: #958cf1;
        background: #f2f0ff;
    }

    .daily-report .dr-sale input {
        flex: 0 0 auto;
        width: 16px;
        height: 16px;
        accent-color: var(--dr-primary);
    }

    .daily-report .dr-table-wrap {
        overflow-x: auto;
        border-radius: 0 0 16px 16px;
    }

    .daily-report .dr-table {
        width: 100%;
        min-width: 1080px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: .88rem;
        font-variant-numeric: tabular-nums;
    }

    .daily-report .dr-table th,
    .daily-report .dr-table td {
        padding: 11px 13px;
        border-top: 1px solid var(--dr-border);
        vertical-align: middle;
    }

    .daily-report .dr-table thead th {
        background: #f2f4fb;
        color: #384765;
    }

    .daily-report .dr-table tbody tr > * {
        background: #fff;
    }

    .daily-report .dr-table tbody tr:hover > * {
        background: #f8f7ff;
    }

    .daily-report .dr-table tfoot tr > * {
        background: #eeedff;
        color: #342b92;
        font-weight: 750;
    }

    .daily-report .dr-name {
        position: sticky;
        left: 0;
        z-index: 1;
        min-width: 150px;
        border-right: 1px solid var(--dr-border);
        text-align: left;
    }

    .daily-report .dr-number {
        text-align: right;
    }

    .daily-report td.dr-number {
        white-space: nowrap;
    }

    .daily-report .dr-revenue {
        color: #087653;
        font-weight: 750;
    }

    .daily-report [hidden] {
        display: none !important;
    }
</style>

<div
    class="daily-report"
    id="daily-report"
    data-storage-key="crm.daily-report.selected-sales.{{ auth()->id() }}"
>
    @if(session('success'))
        <div class="alert alert-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    <header class="dr-hero">
        <div class="dr-eyebrow">Báo cáo bán hàng</div>
        <h1>Báo cáo khách theo ngày</h1>
        <div>Ngày {{ \Carbon\Carbon::parse($reportDate)->format('d/m/Y') }}</div>
    </header>

    <div class="dr-panel dr-toolbar">
        <form method="GET" class="dr-date-form">
            <div>
                <label for="daily-report-date" class="form-label fw-bold mb-1">
                    Ngày báo cáo
                </label>
                <input
                    type="date"
                    id="daily-report-date"
                    name="date"
                    value="{{ $reportDate }}"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-funnel" aria-hidden="true"></i>
                Lọc ngày
            </button>
        </form>

        <form
            id="daily-report-export"
            method="GET"
            action="{{ route('report_daily.exportExcel') }}"
            class="m-0"
        >
            <input type="hidden" name="date" value="{{ $reportDate }}">

            <button type="submit" class="btn btn-success">
                <i class="bi bi-file-earmark-excel" aria-hidden="true"></i>
                <span id="daily-export-label">Xuất Excel</span>
            </button>
        </form>
    </div>

    <section class="dr-panel" aria-labelledby="daily-sale-title">
        <div class="dr-panel-head">
            <div>
                <h2 id="daily-sale-title" class="dr-subtitle">Chọn nhân viên Sale</h2>
                <div class="dr-muted">
                    Lựa chọn được lưu khi đổi ngày. Bỏ chọn để xem và xuất tất cả.
                </div>
            </div>

            <div class="dr-actions">
                <span id="daily-sale-count" class="dr-count" aria-live="polite"></span>

                <button
                    type="button"
                    id="daily-sale-reset"
                    class="btn btn-sm btn-outline-secondary"
                    disabled
                >
                    Bỏ chọn
                </button>
            </div>
        </div>

        <div id="daily-sale-filter" class="dr-sales">
            @forelse($reportRows as $item)
                <label class="dr-sale">
                    <input
                        type="checkbox"
                        name="sale_names[]"
                        value="{{ $item->sale_name }}"
                        form="daily-report-export"
                    >
                    <span>{{ $item->sale_name }}</span>
                </label>
            @empty
                <span class="dr-muted">Chưa có Sale trong báo cáo ngày này.</span>
            @endforelse
        </div>
    </section>

    <section class="dr-panel" aria-labelledby="daily-table-title">
        <div class="dr-panel-head">
            <div>
                <h2 id="daily-table-title" class="dr-subtitle">Chi tiết theo Sale</h2>
                <div class="dr-muted">Dòng tổng cập nhật theo các dòng đang hiển thị.</div>
            </div>
        </div>

        <div class="dr-table-wrap" role="region" aria-label="Bảng chi tiết theo Sale" tabindex="0">
            <table id="daily-report-table" class="dr-table">
                <thead>
                    <tr>
                        <th scope="col" class="dr-name">Tên Sale</th>

                        @foreach($columns as $label)
                            <th scope="col" class="dr-number">{{ $label }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($reportRows as $item)
                        <tr data-sale-name="{{ $item->sale_name }}">
                            <th scope="row" class="dr-name">{{ $item->sale_name }}</th>

                            @foreach($columns as $key => $label)
                                <td
                                    class="dr-number {{ $key === 'total_value' ? 'dr-revenue' : '' }}"
                                    data-value="{{ $item->{$key} ?? 0 }}"
                                >
                                    {{ number_format($item->{$key} ?? 0) }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}" class="text-center dr-muted">
                                Chưa có dữ liệu cho ngày này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th scope="row" class="dr-name">{{ $total->sale_name ?? 'Tổng' }}</th>

                        @foreach($columns as $key => $label)
                            <td class="dr-number">{{ number_format($total->{$key} ?? 0) }}</td>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>

<script>
    (() => {
        const report = document.getElementById('daily-report');
        const storageKey = report.dataset.storageKey;
        const filter = document.getElementById('daily-sale-filter');
        const table = document.getElementById('daily-report-table');
        const resetButton = document.getElementById('daily-sale-reset');
        const countLabel = document.getElementById('daily-sale-count');
        const exportLabel = document.getElementById('daily-export-label');

        const checkboxes = Array.from(filter.querySelectorAll('input[type="checkbox"]'));
        const rows = Array.from(table.querySelectorAll('tbody tr[data-sale-name]'));
        const totalCells = Array.from(table.querySelectorAll('tfoot td'));
        const originalTotals = totalCells.map(cell => cell.textContent.trim());
        const numberFormat = new Intl.NumberFormat('en-US', {
            maximumFractionDigits: 0
        });

        function readSelection() {
            try {
                const names = JSON.parse(localStorage.getItem(storageKey) || '[]');

                return new Set(
                    Array.isArray(names)
                        ? names.filter(name => typeof name === 'string')
                        : []
                );
            } catch {
                return new Set();
            }
        }

        let savedNames = readSelection();

        function saveSelection() {
            try {
                if (savedNames.size > 0) {
                    localStorage.setItem(storageKey, JSON.stringify([...savedNames]));
                } else {
                    localStorage.removeItem(storageKey);
                }
            } catch {
                // Vẫn cho phép lọc trên trang khi trình duyệt chặn lưu.
            }
        }

        function updateReport() {
            let hasSelectionOnPage = false;

            checkboxes.forEach(checkbox => {
                checkbox.checked = savedNames.has(checkbox.value);
                checkbox.closest('.dr-sale').classList.toggle('is-selected', checkbox.checked);
                hasSelectionOnPage = hasSelectionOnPage || checkbox.checked;
            });

            const visibleRows = rows.filter(row => {
                const visible = !hasSelectionOnPage || savedNames.has(row.dataset.saleName);
                row.hidden = !visible;
                return visible;
            });

            totalCells.forEach((cell, index) => {
                if (!hasSelectionOnPage) {
                    cell.textContent = originalTotals[index];
                    return;
                }

                const total = visibleRows.reduce((sum, row) => {
                    return sum + Number(row.cells[index + 1].dataset.value);
                }, 0);

                cell.textContent = numberFormat.format(total);
            });

            if (hasSelectionOnPage) {
                countLabel.textContent = `Đang chọn ${visibleRows.length}/${rows.length} dòng`;
            } else if (savedNames.size > 0) {
                countLabel.textContent = 'Ngày này không có Sale đã chọn';
            } else {
                countLabel.textContent = `Tất cả · ${rows.length} dòng`;
            }

            exportLabel.textContent = hasSelectionOnPage
                ? `Xuất Excel (${visibleRows.length})`
                : 'Xuất Excel toàn bộ';

            resetButton.disabled = savedNames.size === 0;
        }

        filter.addEventListener('change', event => {
            const checkbox = event.target;

            if (!checkbox.matches('input[type="checkbox"]')) {
                return;
            }

            if (checkbox.checked) {
                savedNames.add(checkbox.value);
            } else {
                savedNames.delete(checkbox.value);
            }

            saveSelection();
            updateReport();
        });

        resetButton.addEventListener('click', () => {
            savedNames.clear();
            saveSelection();
            updateReport();
        });

        window.addEventListener('pageshow', event => {
            if (event.persisted) {
                savedNames = readSelection();
            }

            updateReport();
        });

        updateReport();
    })();
</script>
@endsection