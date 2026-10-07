@extends('layouts.app')

@section('content')

<style>
    .invoice-page {
        background: #f5f7fb;
        min-height: calc(100vh - 60px);
        padding: 30px;
    }

    /* Header */
    .invoice-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, .22);
    }

    .invoice-header h2 {
        font-weight: 700;
        margin-bottom: 5px;
        letter-spacing: -.5px;
    }

    .invoice-header p {
        margin: 0;
        opacity: .85;
    }

    .btn-create-invoice {
        background: #fff;
        color: #667eea;
        border: none;
        padding: 11px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all .25s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,.12);
    }

    .btn-create-invoice:hover {
        background: #f8f9ff;
        color: #5a67d8;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,.16);
    }

    /* Stats */
    .stat-card {
        background: #fff;
        border: 0;
        border-radius: 18px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 5px 20px rgba(31, 41, 55, .06);
        transition: all .25s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(31, 41, 55, .1);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        margin-bottom: 14px;
    }

    .stat-icon.purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .stat-icon.green {
        background: #dcfce7;
        color: #16a34a;
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-icon.orange {
        background: #ffedd5;
        color: #ea580c;
    }

    .stat-title {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    /* Main card */
    .invoice-card {
        border: 0;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 5px 25px rgba(31, 41, 55, .07);
        overflow: hidden;
    }

    .invoice-card-header {
        padding: 22px 25px;
        border-bottom: 1px solid #eef0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .invoice-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .invoice-count {
        background: #f3f4f6;
        color: #6b7280;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Table */
    .invoice-table {
        margin: 0;
        min-width: 950px;
    }

    .invoice-table thead th {
        background: #f8fafc;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 16px 20px;
        border-bottom: 1px solid #edf0f4;
        white-space: nowrap;
    }

    .invoice-table tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f6;
        color: #374151;
    }

    .invoice-table tbody tr {
        transition: all .2s ease;
    }

    .invoice-table tbody tr:hover {
        background: #fafbff;
    }

    .invoice-code {
        color: #4f46e5;
        font-weight: 700;
        font-size: 14px;
    }

    .customer-name {
        font-weight: 600;
        color: #111827;
    }

    .phone {
        color: #6b7280;
        font-size: 14px;
    }

    .amount {
        color: #111827;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 20px;
        background: #ecfdf5;
        color: #059669;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .payment-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
    }

    .date-text {
        color: #6b7280;
        font-size: 13px;
        white-space: nowrap;
    }

    /* Action */
    .action-group {
        display: flex;
        gap: 7px;
    }

    .btn-action {
        border: 1px solid #e5e7eb;
        background: #fff;
        border-radius: 9px;
        padding: 7px 12px;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view {
        color: #4f46e5;
    }

    .btn-view:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4338ca;
    }

    .btn-print {
        color: #374151;
    }

    .btn-print:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #111827;
    }

    /* Empty */
    .empty-state {
        padding: 70px 20px !important;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 28px;
    }

    .empty-state h5 {
        font-weight: 700;
        color: #374151;
    }

    .empty-state p {
        color: #9ca3af;
        margin-bottom: 0;
    }

    /* Pagination */
    .invoice-pagination {
        padding: 18px 25px;
        border-top: 1px solid #eef0f4;
    }

    .invoice-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    /* Alert */
    .success-alert {
        border: 0;
        border-radius: 14px;
        padding: 14px 18px;
        background: #ecfdf5;
        color: #047857;
        box-shadow: 0 5px 15px rgba(16, 185, 129, .08);
    }

    /* Mobile */
    @media (max-width: 768px) {
        .invoice-page {
            padding: 15px;
        }

        .invoice-header {
            padding: 22px;
        }

        .invoice-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 18px;
        }

        .btn-create-invoice {
            width: 100%;
        }

        .stat-value {
            font-size: 20px;
        }

        .invoice-card-header {
            padding: 18px;
        }
    }
</style>


<div class="invoice-page">

    {{-- HEADER --}}
    <div class="invoice-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2>
                    📄 Quản lý hóa đơn
                </h2>

                <p>
                    Theo dõi và quản lý tất cả hóa đơn bán hàng
                </p>
            </div>

            <a
                href="{{ route('invoices.create') }}"
                class="btn btn-create-invoice"
            >
                ＋ Tạo hóa đơn mới
            </a>

        </div>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert success-alert mb-4">
            ✓ {{ session('success') }}
        </div>

    @endif


    {{-- STATISTICS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon purple">
                    🧾
                </div>

                <div class="stat-title">
                    Tổng hóa đơn
                </div>

                <div class="stat-value">
                    {{ $invoices->total() }}
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon green">
                    💰
                </div>

                <div class="stat-title">
                    Hóa đơn hiện tại
                </div>

                <div class="stat-value">
                    {{ $invoices->count() }}
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon blue">
                    👥
                </div>

                <div class="stat-title">
                    Khách hàng
                </div>

                <div class="stat-value">
                    {{ $invoices->unique('customer_phone')->count() }}
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon orange">
                    💳
                </div>

                <div class="stat-title">
                    Thanh toán
                </div>

                <div class="stat-value">
                    {{ $invoices->where('payment_method', 'Chuyển khoản')->count() }}
                </div>

            </div>

        </div>

    </div>


    {{-- INVOICE TABLE --}}
    <div class="invoice-card">

        <div class="invoice-card-header">

            <div>

                <div class="invoice-card-title">
                    Danh sách hóa đơn
                </div>

                <small class="text-muted">
                    Các hóa đơn bán hàng gần đây
                </small>

            </div>

            <span class="invoice-count">
                {{ $invoices->total() }} hóa đơn
            </span>

        </div>


        <div class="table-responsive">

            <table class="table invoice-table">

                <thead>

                    <tr>

                        <th>Mã hóa đơn</th>

                        <th>Khách hàng</th>

                        <th>Số điện thoại</th>

                        <th>Tổng tiền</th>

                        <th>Thanh toán</th>

                        <th>Ngày tạo</th>

                        <th>Thao tác</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($invoices as $invoice)

                        <tr>

                            {{-- CODE --}}
                            <td>

                                <span class="invoice-code">
                                    #{{ $invoice->invoice_code }}
                                </span>

                            </td>


                            {{-- CUSTOMER --}}
                            <td>

                                <div class="customer-name">
                                    {{ $invoice->customer_name }}
                                </div>

                            </td>


                            {{-- PHONE --}}
                            <td>

                                <span class="phone">
                                    {{ $invoice->customer_phone }}
                                </span>

                            </td>


                            {{-- TOTAL --}}
                            <td>

                                <span class="amount">

                                    {{ number_format(
                                        $invoice->grand_total,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                    ₫

                                </span>

                            </td>


                            {{-- PAYMENT --}}
                            <td>

                                <span class="payment-badge">

                                    <span class="payment-dot"></span>

                                    {{ $invoice->payment_method }}

                                </span>

                            </td>


                            {{-- DATE --}}
                            <td>

                                <span class="date-text">

                                    {{ $invoice->created_at->format('d/m/Y') }}

                                    <br>

                                    <small>
                                        {{ $invoice->created_at->format('H:i') }}
                                    </small>

                                </span>

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <div class="action-group">

                                    <a
                                        href="{{ route('invoices.show', $invoice) }}"
                                        class="btn-action btn-view"
                                    >
                                        👁 Xem
                                    </a>

                                    <a
                                        href="{{ route('invoices.print', $invoice) }}"
                                        target="_blank"
                                        class="btn-action btn-print"
                                    >
                                        🖨 In
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="empty-state">

                                <div class="empty-icon">
                                    🧾
                                </div>

                                <h5>
                                    Chưa có hóa đơn
                                </h5>

                                <p>
                                    Các hóa đơn được tạo sẽ hiển thị tại đây.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($invoices->hasPages())

            <div class="invoice-pagination">

                {{ $invoices->links() }}

            </div>

        @endif

    </div>

</div>

@endsection