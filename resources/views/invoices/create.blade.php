@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #635bff;
        --primary-dark: #5148e5;
        --secondary: #8b5cf6;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --dark: #111827;
        --muted: #6b7280;
        --border: #e8eaf0;
        --bg: #f6f7fb;
        --card: #ffffff;
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: var(--bg);
    }

    /* ========================================
       PAGE
    ======================================== */

    .invoice-create-page {
        min-height: calc(100vh - 60px);
        padding: 28px;
        background:
            radial-gradient(circle at top right, rgba(99, 91, 255, .08), transparent 30%),
            radial-gradient(circle at bottom left, rgba(139, 92, 246, .06), transparent 28%),
            #f6f7fb;
    }

    /* ========================================
       TOP HEADER
    ======================================== */

    .page-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-title-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-title-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 25px;

        background: linear-gradient(
            135deg,
            #635bff,
            #8b5cf6
        );

        box-shadow:
            0 10px 25px rgba(99, 91, 255, .25);
    }

    .page-title h2 {
        margin: 0;
        font-size: 25px;
        font-weight: 750;
        color: var(--dark);
        letter-spacing: -.5px;
    }

    .page-title p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: 14px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid #dfe2ea;
        background: #fff;
        color: #4b5563;
        border-radius: 11px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s ease;
    }

    .btn-back:hover {
        color: var(--primary);
        border-color: #c9c6ff;
        background: #f8f7ff;
        transform: translateY(-1px);
    }

    /* ========================================
       VALIDATION
    ======================================== */

    .custom-alert {
        border: 0;
        border-radius: 14px;
        padding: 16px 18px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
    }

    /* ========================================
       MAIN CARDS
    ======================================== */

    .modern-card {
        background: var(--card);
        border: 1px solid rgba(0, 0, 0, .04);
        border-radius: 18px;
        box-shadow:
            0 5px 25px rgba(17, 24, 39, .055);

        overflow: hidden;
    }

    .modern-card-header {
        padding: 17px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #eef0f4;
    }

    .modern-card-header.blue {
        color: #fff;
        border: 0;

        background:
            linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );
    }

    .modern-card-header.gradient {
        color: #fff;
        border: 0;

        background:
            linear-gradient(
                135deg,
                #635bff,
                #8b5cf6
            );
    }

    .card-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 700;
    }

    .card-heading-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: rgba(255,255,255,.16);
    }

    .modern-card-body {
        padding: 22px;
    }

    /* ========================================
       FORM
    ======================================== */

    .form-group {
        margin-bottom: 18px;
    }

    .form-label-modern {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }

    .required {
        color: #ef4444;
    }

    .form-control,
    .form-select {
        border-color: #e1e4eb;
        border-radius: 10px;
        min-height: 43px;
        font-size: 14px;
        color: #1f2937;
        transition: all .2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #817aff;
        box-shadow: 0 0 0 4px rgba(99, 91, 255, .10);
    }

    textarea.form-control {
        min-height: 90px;
    }

    .form-text-modern {
        margin-top: 6px;
        color: #9ca3af;
        font-size: 12px;
    }

    /* ========================================
       SEARCH
    ======================================== */

    .search-box {
        display: flex;
        gap: 8px;
    }

    .search-box .form-control {
        flex: 1;
    }

    .btn-search {
        min-width: 92px;
        border: 0;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;

        background:
            linear-gradient(
                135deg,
                #635bff,
                #764ba2
            );

        transition: all .2s ease;
    }

    .btn-search:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow:
            0 7px 18px rgba(99, 91, 255, .25);
    }

    /* ========================================
       LEAD
    ======================================== */

    .lead-result {
        margin-top: 10px;
    }

    .lead-option {
        border-radius: 11px !important;
        border-color: #e4e6ed !important;
        transition: all .2s ease;
    }

    .lead-option:hover {
        border-color: #aaa5ff !important;
        background: #f8f7ff;
    }

    .selected-lead {
        border: 0;
        border-radius: 12px;
        background: linear-gradient(
            135deg,
            #ecfdf5,
            #f0fdf4
        );
        color: #047857;
        padding: 12px 14px;
    }

    /* ========================================
       PRODUCT
    ======================================== */

    .product-card {
        margin-top: 24px;
    }

    .btn-add-product {
        border: 0;
        color: #fff;
        background: rgba(255,255,255,.16);
        border-radius: 9px;
        padding: 8px 13px;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
    }

    .btn-add-product:hover {
        background: #fff;
        color: var(--primary);
    }

    .product-table-wrapper {
        overflow-x: auto;
    }

    .product-table {
        margin: 0;
        min-width: 760px;
    }

    .product-table thead th {
        background: #f8f9fc;
        color: #6b7280;
        border-bottom: 1px solid #e9ebf0;
        padding: 13px 14px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .35px;
        font-weight: 700;
        white-space: nowrap;
    }

    .product-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f0f1f4;
        vertical-align: middle;
    }

    .product-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .product-table .form-control,
    .product-table .form-select {
        min-height: 40px;
    }

    .unit-price-display {
        background: #f8f9fc !important;
        font-weight: 600;
        color: #4b5563;
    }

    .line-total {
        color: var(--primary);
        font-weight: 750;
        white-space: nowrap;
    }

    .btn-delete-product {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        transition: all .2s ease;
    }

    .btn-delete-product:hover {
        transform: scale(1.05);
    }

    /* ========================================
       PAYMENT CARD
    ======================================== */

    .payment-card {
        margin-top: 20px;
    }

    .payment-content {
        padding: 24px;
    }

    .payment-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--primary);
        font-size: 15px;
        font-weight: 750;
        margin-bottom: 18px;
    }

    .payment-title-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eeecff;
        color: var(--primary);
    }

    .payment-divider {
        height: 100%;
        width: 1px;
        background: #edf0f4;
    }

    /* ========================================
       TOTAL
    ======================================== */

    .summary-box {
        height: 100%;
        padding-left: 5px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 0;
        color: #4b5563;
        font-size: 14px;
    }

    .summary-row strong {
        color: #1f2937;
    }

    .summary-row.discount {
        color: #ef4444;
    }

    .summary-row.discount strong {
        color: #ef4444;
    }

    .summary-row.fee {
        color: #059669;
    }

    .summary-row.fee strong {
        color: #059669;
    }

    .summary-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 0;
        margin-top: 5px;
        border-top: 1px dashed #dfe2e8;
        border-bottom: 1px dashed #dfe2e8;
    }

    .summary-total span {
        font-size: 16px;
        font-weight: 800;
        color: #111827;
    }

    .summary-total strong {
        font-size: 24px;
        font-weight: 800;
        color: var(--primary);
    }

    .deposit-row {
        display: flex;
        justify-content: space-between;
        padding: 13px 0 6px;
        color: #059669;
    }

    .remaining-box {
        margin-top: 10px;
        padding: 14px 16px;
        border-radius: 12px;

        background:
            linear-gradient(
                135deg,
                #ecfdf5,
                #f0fdf4
            );

        color: #047857;
    }

    .remaining-box .remaining-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .remaining-label {
        font-size: 13px;
        font-weight: 800;
    }

    .remaining-value {
        font-size: 18px;
        font-weight: 800;
    }

    /* ========================================
       FOOTER ACTION
    ======================================== */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
    }

    .btn-cancel {
        min-width: 90px;
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 600;
        border: 1px solid #dfe2e8;
        background: #fff;
        color: #6b7280;
    }

    .btn-cancel:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-save {
        border: 0;
        border-radius: 10px;
        padding: 11px 22px;
        font-weight: 700;
        color: #fff;

        background:
            linear-gradient(
                135deg,
                #635bff,
                #764ba2
            );

        box-shadow:
            0 7px 18px rgba(99, 91, 255, .22);

        transition: all .2s ease;
    }

    .btn-save:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow:
            0 10px 25px rgba(99, 91, 255, .30);
    }

    /* ========================================
       LOADING
    ======================================== */

    .search-loading {
        padding: 10px 0;
        color: var(--primary);
        font-size: 13px;
    }

    /* ========================================
       RESPONSIVE
    ======================================== */

    @media (max-width: 991px) {
        .invoice-create-page {
            padding: 20px 15px;
        }

        .page-top {
            align-items: flex-start;
            gap: 15px;
        }

        .payment-divider {
            display: none;
        }

        .summary-box {
            padding-left: 0;
            margin-top: 20px;
        }
    }

    @media (max-width: 575px) {
        .page-top {
            flex-direction: column;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .page-title h2 {
            font-size: 21px;
        }

        .page-title-icon {
            width: 46px;
            height: 46px;
            font-size: 21px;
        }

        .modern-card-body,
        .payment-content {
            padding: 17px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-save {
            width: 100%;
        }

        .summary-total strong {
            font-size: 20px;
        }
    }
</style>


<div class="invoice-create-page">

    {{-- ==========================================
         HEADER
    =========================================== --}}
    <div class="page-top">

        <div class="page-title-wrapper">

            <div class="page-title-icon">
                <i class="bi bi-receipt"></i>
            </div>

            <div class="page-title">

                <h2>
                    Tạo hóa đơn
                </h2>

                <p>
                    Tạo đơn hàng mới và quản lý thông tin khách hàng
                </p>

            </div>

        </div>

        <a
            href="{{ route('invoices.index') }}"
            class="btn-back"
        >
            <i class="bi bi-arrow-left"></i>
            Danh sách hóa đơn
        </a>

    </div>


    {{-- ==========================================
         VALIDATION
    =========================================== --}}
    @if (!empty($errors) && $errors->any())

        <div class="alert alert-danger custom-alert mb-4">

            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-triangle"></i>
                Có lỗi xảy ra:
            </div>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('invoices.store') }}"
        id="invoiceForm"
    >

        @csrf

        <input
            type="hidden"
            name="lead_id"
            id="lead_id"
            value="{{ old('lead_id', isset($lead) ? $lead->id : '') }}"
        >


        <div class="row g-4">


            {{-- ==========================================
                 LEFT - CUSTOMER
            =========================================== --}}
            <div class="col-lg-4">

                <div class="modern-card">

                    <div class="modern-card-header blue">

                        <div class="card-heading">

                            <span class="card-heading-icon">
                                <i class="bi bi-person"></i>
                            </span>

                            <span>
                                Thông tin khách hàng
                            </span>

                        </div>

                    </div>


                    <div class="modern-card-body">


                        {{-- SALE --}}
                        <div class="form-group">

                            <label class="form-label-modern">

                                Tên Sale

                                <span class="required">*</span>

                            </label>

                            <input
                                type="text"
                                name="sale_name"
                                id="sale_name"
                                class="form-control"
                                placeholder="Nhập tên nhân viên Sale..."
                                value="{{ old('sale_name', auth()->user()->name ?? '') }}"
                                required
                            >

                        </div>


                        {{-- SEARCH PHONE --}}
                        <div class="form-group">

                            <label class="form-label-modern">

                                <i class="bi bi-search"></i>

                                Tìm khách hàng

                            </label>

                            <div class="search-box">

                                <input
                                    type="text"
                                    id="search_phone"
                                    class="form-control"
                                    placeholder="Nhập số điện thoại..."
                                    autocomplete="off"
                                    value="{{ old('customer_phone', isset($lead) ? $lead->phone : '') }}"
                                >

                                <button
                                    type="button"
                                    class="btn-search"
                                    id="searchPhoneBtn"
                                >

                                    <i class="bi bi-search"></i>
                                    Tìm

                                </button>

                            </div>

                            <div class="form-text-modern">

                                Nhập tối thiểu 6 số để tìm Lead có sẵn.

                            </div>

                        </div>


                        {{-- LOADING --}}
                        <div
                            id="searchLoading"
                            class="search-loading"
                            style="display:none;"
                        >

                            <span class="spinner-border spinner-border-sm"></span>

                            Đang tìm khách hàng...

                        </div>


                        {{-- LEAD RESULTS --}}
                        <div
                            id="leadResults"
                            class="lead-result"
                            style="display:none;"
                        >

                            <label class="form-label-modern">
                                Chọn Lead
                            </label>

                            <div id="leadResultList"></div>

                        </div>


                        {{-- CUSTOMER --}}
                        <div class="form-group">

                            <label class="form-label-modern">

                                Khách hàng

                                <span class="required">*</span>

                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                id="customer_name"
                                class="form-control"
                                placeholder="Nhập họ tên khách hàng..."
                                value="{{ old('customer_name', isset($lead) ? ($lead->name ?? $lead->customer_name ?? '') : '') }}"
                                required
                            >

                        </div>


                        {{-- PHONE --}}
                        <div class="form-group">

                            <label class="form-label-modern">

                                Số điện thoại

                                <span class="required">*</span>

                            </label>

                            <input
                                type="text"
                                name="customer_phone"
                                id="customer_phone"
                                class="form-control"
                                placeholder="Nhập số điện thoại khách hàng..."
                                value="{{ old('customer_phone', isset($lead) ? $lead->phone : '') }}"
                                required
                            >

                        </div>


                        {{-- ADDRESS --}}
                        <div class="form-group">

                            <label class="form-label-modern">

                                <i class="bi bi-geo-alt"></i>

                                Địa chỉ giao hàng

                            </label>

                            <textarea
                                name="customer_address"
                                id="customer_address"
                                class="form-control"
                                rows="3"
                                placeholder="Nhập địa chỉ giao hàng..."
                            >{{ old('customer_address', isset($lead) ? $lead->address : '') }}</textarea>

                        </div>


                        {{-- SELECTED LEAD --}}
                        <div
                            id="selectedLeadBox"
                            class="selected-lead mb-3"
                            style="{{ old('lead_id', isset($lead) ? $lead->id : '') ? '' : 'display:none;' }}"
                        >

                            <i class="bi bi-check-circle-fill"></i>

                            Lead đang chọn:

                            <strong>
                                #<span id="selectedLeadId">
                                    {{ old('lead_id', isset($lead) ? $lead->id : '') }}
                                </span>
                            </strong>

                        </div>


                        {{-- NOTE --}}
                        <div>

                            <label class="form-label-modern">

                                <i class="bi bi-chat-left-text"></i>

                                Ghi chú

                            </label>

                            <textarea
                                name="note"
                                class="form-control"
                                rows="3"
                                placeholder="Ghi chú hóa đơn..."
                            >{{ old('note') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==========================================
                 RIGHT
            =========================================== --}}
            <div class="col-lg-8">


                {{-- PRODUCT --}}
                <div class="modern-card">

                    <div class="modern-card-header gradient">

                        <div class="card-heading">

                            <span class="card-heading-icon">
                                <i class="bi bi-box-seam"></i>
                            </span>

                            <span>
                                Danh sách sản phẩm
                            </span>

                        </div>


                        <button
                            type="button"
                            class="btn-add-product"
                            id="addItemBtn"
                        >

                            <i class="bi bi-plus-lg"></i>

                            Thêm sản phẩm

                        </button>

                    </div>


                    <div class="product-table-wrapper">

                        <table class="table product-table">

                            <thead>

                                <tr>

                                    <th>
                                        Sản phẩm
                                    </th>

                                    <th class="text-end">
                                        Đơn giá
                                    </th>

                                    <th
                                        class="text-center"
                                        style="width:100px"
                                    >
                                        SL
                                    </th>

                                    <th class="text-end">
                                        Thành tiền
                                    </th>

                                    <th
                                        class="text-center"
                                        style="width:60px"
                                    >
                                        #
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="itemsBody"></tbody>

                        </table>

                    </div>

                </div>


                {{-- PAYMENT --}}
                <div class="modern-card payment-card">

                    <div class="payment-content">

                        <div class="row g-4">


                            {{-- LEFT --}}
                            <div class="col-md-6">

                                <div class="payment-title">

                                    <span class="payment-title-icon">
                                        <i class="bi bi-sliders"></i>
                                    </span>

                                    Chiết khấu & Chi phí

                                </div>


                                {{-- DISCOUNT --}}
                                <div class="form-group">

                                    <label class="form-label-modern">
                                        Chiết khấu
                                    </label>

                                    <input
                                        type="number"
                                        name="discount_amount"
                                        id="discount_amount"
                                        class="form-control calculate-trigger"
                                        min="0"
                                        step="any"
                                        value="{{ old('discount_amount', 0) }}"
                                    >

                                </div>


                                {{-- OTHER DISCOUNT --}}
                                <div class="form-group">

                                    <label class="form-label-modern">
                                        Chiết khấu khác
                                    </label>

                                    <input
                                        type="number"
                                        name="other_discount"
                                        id="other_discount"
                                        class="form-control calculate-trigger"
                                        min="0"
                                        step="any"
                                        value="{{ old('other_discount', 0) }}"
                                    >

                                </div>


                                {{-- FEE --}}
                                <div class="form-group">

                                    <label class="form-label-modern">
                                        Phí khác
                                    </label>

                                    <input
                                        type="number"
                                        name="other_fee"
                                        id="other_fee"
                                        class="form-control calculate-trigger"
                                        min="0"
                                        step="any"
                                        value="{{ old('other_fee', 0) }}"
                                    >

                                </div>


                                {{-- DEPOSIT --}}
                                <div class="row g-2">

                                    <div class="col-6">

                                        <label class="form-label-modern">
                                            Tiền cọc
                                        </label>

                                        <input
                                            type="number"
                                            name="deposit_amount"
                                            id="deposit_amount"
                                            class="form-control calculate-trigger"
                                            min="0"
                                            step="any"
                                            value="{{ old('deposit_amount', 0) }}"
                                        >

                                    </div>


                                    <div class="col-6">

                                        <label class="form-label-modern">
                                            Hình thức cọc
                                        </label>

                                        <select
                                            name="deposit_type"
                                            class="form-select"
                                        >

                                            <option
                                                value="Chuyển khoản"
                                                {{ old('deposit_type') == 'Chuyển khoản' ? 'selected' : '' }}
                                            >
                                                Chuyển khoản
                                            </option>

                                            <option
                                                value="Tiền mặt"
                                                {{ old('deposit_type') == 'Tiền mặt' ? 'selected' : '' }}
                                            >
                                                Tiền mặt
                                            </option>

                                            <option
                                                value="Quẹt thẻ"
                                                {{ old('deposit_type') == 'Quẹt thẻ' ? 'selected' : '' }}
                                            >
                                                Quẹt thẻ
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            {{-- RIGHT --}}
                            <div class="col-md-6">

                                <div class="summary-box">

                                    <div class="payment-title">

                                        <span class="payment-title-icon">
                                            <i class="bi bi-calculator"></i>
                                        </span>

                                        Tổng kết thanh toán

                                    </div>


                                    <div class="summary-row">

                                        <span>
                                            Tổng tiền sản phẩm
                                        </span>

                                        <strong id="itemsTotalDisplay">
                                            0 ₫
                                        </strong>

                                    </div>


                                    <div class="summary-row discount">

                                        <span>
                                            Chiết khấu hóa đơn
                                        </span>

                                        <strong id="discountDisplay">
                                            - 0 ₫
                                        </strong>

                                    </div>


                                    <div class="summary-row discount">

                                        <span>
                                            Chiết khấu khác
                                        </span>

                                        <strong id="otherDiscountDisplay">
                                            - 0 ₫
                                        </strong>

                                    </div>


                                    <div class="summary-row fee">

                                        <span>
                                            Phí khác
                                        </span>

                                        <strong id="otherFeeDisplay">
                                            + 0 ₫
                                        </strong>

                                    </div>


                                    <div class="summary-total">

                                        <span>
                                            TỔNG THANH TOÁN
                                        </span>

                                        <strong id="grandTotalDisplay">
                                            0 ₫
                                        </strong>

                                    </div>


                                    <div class="deposit-row">

                                        <span>
                                            <i class="bi bi-wallet2"></i>
                                            Đã cọc
                                        </span>

                                        <strong id="depositDisplay">
                                            0 ₫
                                        </strong>

                                    </div>


                                    <div class="remaining-box">

                                        <div class="remaining-content">

                                            <span
                                                class="remaining-label"
                                                id="remainingLabel"
                                            >
                                                CÒN LẠI PHẢI THU:
                                            </span>

                                            <strong
                                                class="remaining-value"
                                                id="remainingDisplay"
                                            >
                                                0 ₫
                                            </strong>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ACTION --}}
                <div class="form-actions">

                    <a
                        href="{{ route('invoices.index') }}"
                        class="btn-cancel"
                    >
                        Hủy
                    </a>

                    <button
                        type="submit"
                        class="btn-save"
                    >

                        <i class="bi bi-check2-circle"></i>

                        LƯU HÓA ĐƠN

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const productsData = @json($products ?? []);

    const oldItemsData = @json(old('items', []));


    /* ==========================================
       ELEMENTS
    =========================================== */

    const searchPhone = document.getElementById('search_phone');
    const searchButton = document.getElementById('searchPhoneBtn');
    const searchLoading = document.getElementById('searchLoading');

    const leadResults = document.getElementById('leadResults');
    const leadResultList = document.getElementById('leadResultList');

    const leadId = document.getElementById('lead_id');
    const customerName = document.getElementById('customer_name');
    const customerPhone = document.getElementById('customer_phone');
    const customerAddress = document.getElementById('customer_address');

    const selectedLeadBox = document.getElementById('selectedLeadBox');
    const selectedLeadId = document.getElementById('selectedLeadId');

    const itemsBody = document.getElementById('itemsBody');
    const addItemButton = document.getElementById('addItemBtn');

    const discountAmountInput = document.getElementById('discount_amount');
    const otherDiscountInput = document.getElementById('other_discount');
    const otherFeeInput = document.getElementById('other_fee');
    const depositAmountInput = document.getElementById('deposit_amount');

    const itemsTotalDisplay = document.getElementById('itemsTotalDisplay');
    const discountDisplay = document.getElementById('discountDisplay');
    const otherDiscountDisplay = document.getElementById('otherDiscountDisplay');
    const otherFeeDisplay = document.getElementById('otherFeeDisplay');
    const grandTotalDisplay = document.getElementById('grandTotalDisplay');
    const depositDisplay = document.getElementById('depositDisplay');

    const remainingLabel = document.getElementById('remainingLabel');
    const remainingDisplay = document.getElementById('remainingDisplay');


    /* ==========================================
       MONEY
    =========================================== */

    function formatMoney(value) {

        value = Number(value) || 0;

        return new Intl.NumberFormat('vi-VN')
            .format(Math.round(value)) + ' ₫';

    }


    /* ==========================================
       ESCAPE HTML
    =========================================== */

    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value || '';

        return div.innerHTML;

    }


    /* ==========================================
       PRODUCT OPTIONS
    =========================================== */

    function buildProductOptions(selectedProductId) {

        let options =
            '<option value="">-- Chọn sản phẩm --</option>';

        if (Array.isArray(productsData)) {

            productsData.forEach(function (product) {

                const isSelected =
                    String(product.id) === String(selectedProductId)
                        ? 'selected'
                        : '';

                options += `
                    <option
                        value="${product.id}"
                        data-price="${product.price}"
                        ${isSelected}
                    >
                        ${escapeHtml(product.name)}
                    </option>
                `;

            });

        }

        return options;

    }


    /* ==========================================
       SELECT LEAD
    =========================================== */

    function selectLead(lead) {

        leadId.value = lead.id || '';

        customerName.value = lead.name || '';

        customerPhone.value =
            lead.phone || searchPhone.value.trim();

        customerAddress.value =
            lead.address || '';

        selectedLeadId.textContent = lead.id;

        selectedLeadBox.style.display = 'block';

        leadResults.style.display = 'none';

        leadResultList.innerHTML = '';

        searchPhone.value =
            lead.phone || searchPhone.value.trim();

    }


    /* ==========================================
       SEARCH LEAD
    =========================================== */

    function searchLead() {

        const phone = searchPhone.value.trim();

        if (phone.length < 6) {

            alert(
                'Vui lòng nhập ít nhất 6 số điện thoại.'
            );

            return;

        }


        searchLoading.style.display = 'block';

        leadResults.style.display = 'none';

        leadResultList.innerHTML = '';


        const url =
            "{{ route('invoices.search-leads-by-phone') }}" +
            "?phone=" +
            encodeURIComponent(phone);


        fetch(url, {

            method: 'GET',

            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }

        })

        .then(res => res.json())

        .then(data => {

            searchLoading.style.display = 'none';


            if (!data.success) {

                alert(
                    data.message ||
                    'Không thể tìm khách hàng.'
                );

                return;

            }


            if (
                !data.leads ||
                data.leads.length === 0
            ) {

                leadResults.style.display = 'block';

                leadResultList.innerHTML = `

                    <div class="alert alert-warning mb-0">

                        <i class="bi bi-exclamation-triangle"></i>

                        Không tìm thấy Lead có số điện thoại:

                        <strong>
                            ${escapeHtml(phone)}
                        </strong>

                    </div>

                `;

                return;

            }


            if (data.leads.length === 1) {

                selectLead(data.leads[0]);

                return;

            }


            leadResults.style.display = 'block';


            let html = '';


            data.leads.forEach(function (lead) {

                html += `

                    <button
                        type="button"
                        class="btn btn-outline-primary w-100 text-start mb-2 lead-option"
                        data-lead-id="${lead.id}"
                    >

                        <div class="d-flex justify-content-between">

                            <strong>
                                ${escapeHtml(
                                    lead.name ||
                                    'Chưa có tên'
                                )}
                            </strong>

                            <span>
                                #${lead.id}
                            </span>

                        </div>

                        <div class="small mt-1">

                            <i class="bi bi-telephone"></i>

                            ${escapeHtml(
                                lead.phone || phone
                            )}

                        </div>

                        <div class="small text-muted mt-1">

                            <i class="bi bi-geo-alt"></i>

                            ${escapeHtml(
                                lead.address ||
                                'Chưa có địa chỉ'
                            )}

                        </div>

                    </button>

                `;

            });


            leadResultList.innerHTML = html;


            leadResultList
                .querySelectorAll('.lead-option')
                .forEach(button => {

                    button.addEventListener(
                        'click',
                        function () {

                            const id =
                                this.dataset.leadId;

                            const selected =
                                data.leads.find(
                                    item =>
                                        String(item.id) ===
                                        String(id)
                                );

                            if (selected) {
                                selectLead(selected);
                            }

                        }
                    );

                });

        })

        .catch(err => {

            searchLoading.style.display = 'none';

            console.error(err);

            alert(
                'Có lỗi xảy ra khi tìm khách hàng.'
            );

        });

    }


    searchButton.addEventListener(
        'click',
        searchLead
    );


    searchPhone.addEventListener(
        'keydown',
        function (e) {

            if (e.key === 'Enter') {

                e.preventDefault();

                searchLead();

            }

        }
    );


    /* ==========================================
       ADD PRODUCT
    =========================================== */

    function addItem(
        productId = '',
        quantity = 1
    ) {

        const index =
            itemsBody.querySelectorAll('tr').length;


        const row =
            document.createElement('tr');


        let price = 0;


        if (
            productId &&
            Array.isArray(productsData)
        ) {

            const matchedProduct =
                productsData.find(
                    p =>
                        String(p.id) ===
                        String(productId)
                );

            if (matchedProduct) {

                price =
                    Number(
                        matchedProduct.price
                    ) || 0;

            }

        }


        row.innerHTML = `

            <td>

                <select
                    name="items[${index}][product_id]"
                    class="form-select product-select"
                    required
                >

                    ${buildProductOptions(productId)}

                </select>

            </td>


            <td class="text-end">

                <input
                    type="text"
                    class="form-control text-end unit-price-display"
                    value="${formatMoney(price)}"
                    readonly
                >

                <input
                    type="hidden"
                    class="unit-price"
                    value="${price}"
                >

            </td>


            <td>

                <input
                    type="number"
                    name="items[${index}][quantity]"
                    class="form-control text-center quantity"
                    value="${quantity}"
                    min="0.01"
                    step="any"
                    required
                >

            </td>


            <td class="text-end">

                <span class="line-total">
                    ${formatMoney(price * quantity)}
                </span>

            </td>


            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-outline-danger btn-delete-product btn-sm remove-item"
                >

                    <i class="bi bi-trash"></i>

                </button>

            </td>

        `;


        itemsBody.appendChild(row);


        bindRow(row);

        calculateTotals();

    }


    /* ==========================================
       REINDEX
    =========================================== */

    function reindexRows() {

        itemsBody
            .querySelectorAll('tr')
            .forEach((row, index) => {

                const select =
                    row.querySelector(
                        '.product-select'
                    );

                const qty =
                    row.querySelector(
                        '.quantity'
                    );


                if (select) {

                    select.name =
                        `items[${index}][product_id]`;

                }


                if (qty) {

                    qty.name =
                        `items[${index}][quantity]`;

                }

            });

    }


    /* ==========================================
       CALCULATE ROW
    =========================================== */

    function calculateRow(row) {

        const price =
            Number(
                row.querySelector(
                    '.unit-price'
                ).value
            ) || 0;


        const qty =
            Number(
                row.querySelector(
                    '.quantity'
                ).value
            ) || 0;


        const total =
            price * qty;


        row.querySelector(
            '.line-total'
        ).textContent =
            formatMoney(total);


        calculateTotals();

    }


    /* ==========================================
       BIND PRODUCT ROW
    =========================================== */

    function bindRow(row) {

        const productSelect =
            row.querySelector(
                '.product-select'
            );


        const quantity =
            row.querySelector(
                '.quantity'
            );


        const removeButton =
            row.querySelector(
                '.remove-item'
            );


        productSelect.addEventListener(
            'change',
            function () {

                const option =
                    this.options[
                        this.selectedIndex
                    ];


                const price =
                    Number(
                        option
                            ? option.dataset.price
                            : 0
                    ) || 0;


                row.querySelector(
                    '.unit-price'
                ).value = price;


                row.querySelector(
                    '.unit-price-display'
                ).value =
                    formatMoney(price);


                calculateRow(row);

            }
        );


        quantity.addEventListener(
            'input',
            function () {

                calculateRow(row);

            }
        );


        removeButton.addEventListener(
            'click',
            function () {

                if (
                    itemsBody.querySelectorAll(
                        'tr'
                    ).length > 1
                ) {

                    row.remove();

                    reindexRows();

                    calculateTotals();

                } else {

                    alert(
                        'Hóa đơn phải có ít nhất 1 sản phẩm.'
                    );

                }

            }
        );

    }


    /* ==========================================
       TOTALS
    =========================================== */

    function calculateTotals() {

        let itemsTotal = 0;


        itemsBody
            .querySelectorAll('tr')
            .forEach(row => {

                const price =
                    Number(
                        row.querySelector(
                            '.unit-price'
                        ).value
                    ) || 0;


                const qty =
                    Number(
                        row.querySelector(
                            '.quantity'
                        ).value
                    ) || 0;


                itemsTotal +=
                    price * qty;

            });


        const discountAmount =
            Number(
                discountAmountInput.value
            ) || 0;


        const otherDiscount =
            Number(
                otherDiscountInput.value
            ) || 0;


        const otherFee =
            Number(
                otherFeeInput.value
            ) || 0;


        const depositAmount =
            Number(
                depositAmountInput.value
            ) || 0;


        const grandTotal =
            Math.max(
                0,
                itemsTotal -
                discountAmount -
                otherDiscount +
                otherFee
            );


        const diff =
            grandTotal -
            depositAmount;


        itemsTotalDisplay.textContent =
            formatMoney(itemsTotal);


        discountDisplay.textContent =
            '- ' +
            formatMoney(discountAmount);


        otherDiscountDisplay.textContent =
            '- ' +
            formatMoney(otherDiscount);


        otherFeeDisplay.textContent =
            '+ ' +
            formatMoney(otherFee);


        grandTotalDisplay.textContent =
            formatMoney(grandTotal);


        depositDisplay.textContent =
            formatMoney(depositAmount);


        if (diff < 0) {

            remainingLabel.textContent =
                'HOÀN TRẢ LẠI:';

            remainingLabel.className =
                'remaining-label text-primary';


            remainingDisplay.textContent =
                formatMoney(
                    Math.abs(diff)
                );


            remainingDisplay.className =
                'remaining-value text-primary';

        }

        else if (diff === 0) {

            remainingLabel.textContent =
                'CÒN LẠI PHẢI THU:';


            remainingLabel.className =
                'remaining-label';


            remainingDisplay.textContent =
                '0 ₫ (Đã đủ)';


            remainingDisplay.className =
                'remaining-value';

        }

        else {

            remainingLabel.textContent =
                'CÒN LẠI PHẢI THU:';


            remainingLabel.className =
                'remaining-label text-danger';


            remainingDisplay.textContent =
                formatMoney(diff);


            remainingDisplay.className =
                'remaining-value text-danger';

        }

    }


    /* ==========================================
       CALCULATE INPUT
    =========================================== */

    document
        .querySelectorAll(
            '.calculate-trigger'
        )
        .forEach(input => {

            input.addEventListener(
                'input',
                calculateTotals
            );

        });


    /* ==========================================
       ADD BUTTON
    =========================================== */

    addItemButton.addEventListener(
        'click',
        function () {

            addItem();

        }
    );


    /* ==========================================
       OLD ITEMS
    =========================================== */

    const oldItemsKeys =
        Object.keys(oldItemsData);


    if (oldItemsKeys.length > 0) {

        oldItemsKeys.forEach(key => {

            const item =
                oldItemsData[key];

            addItem(
                item.product_id,
                item.quantity
            );

        });

    } else {

        addItem();

    }

});
</script>

@endsection
