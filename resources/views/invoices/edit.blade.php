@extends('layouts.app')

@section('content')

@php
    $savedManual = $invoice->discount_manual
        ?? $invoice->discount_amount
        ?? 0;

    $savedOther = $invoice->discount_retail
        ?? $invoice->other_discount
        ?? 0;

    if (($invoice->discount_total ?? 0) > 0) {
        $savedOther = max(
            0,
            $invoice->discount_total - $savedManual
        );
    }

    $savedItems = $invoice->items->map(function ($item) {
        return [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'product_name' => $item->product_name,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
        ];
    })->values()->all();

    $defaults = [
        'lead_id' => $invoice->lead_id,
        'sale_name' => $invoice->sale_name,
        'showroom_id' => $invoice->showroom_id,
        'customer_name' => $invoice->customer_name,
        'customer_phone' => $invoice->customer_phone,
        'customer_address' => $invoice->customer_address,
        'note' => $invoice->note,

        'discount_amount' => $savedManual,
        'other_discount' => $savedOther,
        'other_fee' => $invoice->other_fee ?? 0,

        'deposit_amount' => $invoice->deposit_amount
            ?? $invoice->deposit
            ?? $invoice->advance_payment
            ?? 0,

        'deposit_type' => $invoice->deposit_type
            ?? $invoice->payment_method
            ?? 'Chuyển khoản',
    ];

    $formValue = function ($key, $fallback = null) use ($defaults) {
        return old(
            $key,
            array_key_exists($key, $defaults)
                ? $defaults[$key]
                : $fallback
        );
    };

    $initialItems = old('items', $savedItems);

    $catalogProducts = collect($products ?? [])
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
            ];
        })
        ->values()
        ->all();

    $leadSearchUrl = route('invoices.search-leads-by-phone');
@endphp

<style>
    .invoice-edit-page {
        --edit-primary: #635bff;
        --edit-secondary: #8b5cf6;
        --edit-dark: #111827;
        --edit-muted: #6b7280;
        --edit-border: #e8eaf0;

        min-height: calc(100vh - 60px);
        padding: 28px;

        background:
            radial-gradient(
                circle at top right,
                rgba(99, 91, 255, .08),
                transparent 30%
            ),
            radial-gradient(
                circle at bottom left,
                rgba(139, 92, 246, .06),
                transparent 28%
            ),
            #f6f7fb;
    }

    .invoice-edit-page * {
        box-sizing: border-box;
    }

    .invoice-edit-page .page-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .invoice-edit-page .page-title-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .invoice-edit-page .page-title-icon {
        width: 54px;
        height: 54px;
        flex-shrink: 0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 25px;
        background: linear-gradient(135deg, #635bff, #8b5cf6);
        box-shadow: 0 10px 25px rgba(99, 91, 255, .25);
    }

    .invoice-edit-page .page-title h2 {
        margin: 0;
        color: var(--edit-dark);
        font-size: 25px;
        font-weight: 750;
    }

    .invoice-edit-page .page-title p {
        margin: 5px 0 0;
        color: var(--edit-muted);
        font-size: 14px;
    }

    .invoice-edit-page .btn-back,
    .invoice-edit-page .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid #dfe2ea;
        border-radius: 11px;
        background: #fff;
        color: #4b5563;
        font-weight: 600;
        text-decoration: none;
    }

    .invoice-edit-page .btn-back:hover,
    .invoice-edit-page .btn-cancel:hover {
        color: var(--edit-primary);
        background: #f8f7ff;
        border-color: #c9c6ff;
    }

    .invoice-edit-page .modern-card {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .04);
        border-radius: 18px;
        box-shadow: 0 5px 25px rgba(17, 24, 39, .055);
        overflow: hidden;
    }

    .invoice-edit-page .modern-card-header {
        padding: 17px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .invoice-edit-page .modern-card-header.blue {
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
    }

    .invoice-edit-page .modern-card-header.gradient {
        color: #fff;
        background: linear-gradient(135deg, #635bff, #8b5cf6);
    }

    .invoice-edit-page .card-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 700;
    }

    .invoice-edit-page .card-heading-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: rgba(255, 255, 255, .16);
    }

    .invoice-edit-page .modern-card-body {
        padding: 22px;
    }

    .invoice-edit-page .form-group {
        margin-bottom: 18px;
    }

    .invoice-edit-page .form-label-modern {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
    }

    .invoice-edit-page .required {
        color: #ef4444;
    }

    .invoice-edit-page .form-control,
    .invoice-edit-page .form-select {
        min-height: 43px;
        border-color: #e1e4eb;
        border-radius: 10px;
        color: #1f2937;
        font-size: 14px;
    }

    .invoice-edit-page .form-control:focus,
    .invoice-edit-page .form-select:focus {
        border-color: #817aff;
        box-shadow: 0 0 0 4px rgba(99, 91, 255, .10);
    }

    .invoice-edit-page textarea.form-control {
        min-height: 90px;
    }

    .invoice-edit-page .form-text-modern {
        margin-top: 6px;
        color: #9ca3af;
        font-size: 12px;
    }

    .invoice-edit-page .search-box {
        display: flex;
        gap: 8px;
    }

    .invoice-edit-page .search-box input {
        min-width: 0;
        flex: 1;
    }

    .invoice-edit-page .btn-search {
        min-width: 82px;
        border: 0;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;
        background: linear-gradient(135deg, #635bff, #764ba2);
    }

    .invoice-edit-page .selected-lead {
        padding: 12px 14px;
        border-radius: 12px;
        background: #ecfdf5;
        color: #047857;
    }

    .invoice-edit-page .lead-option {
        display: block;
        width: 100%;
        margin-bottom: 8px;
        padding: 12px;
        border: 1px solid #e4e6ed;
        border-radius: 10px;
        background: #fff;
        color: #374151;
        text-align: left;
    }

    .invoice-edit-page .lead-option:hover {
        border-color: #aaa5ff;
        background: #f8f7ff;
    }

    .invoice-edit-page .product-search-card {
        position: relative;
        z-index: 10;
        overflow: visible;
    }

    .invoice-edit-page .product-search-card .modern-card-header {
        flex-wrap: wrap;
        border-radius: 18px 18px 0 0;
    }

    .invoice-edit-page .product-search-bar {
        display: flex;
        flex: 1;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        min-width: 0;
    }

    .invoice-edit-page .product-search-box {
        position: relative;
        flex: 1;
        min-width: 210px;
    }

    .invoice-edit-page .btn-add-product {
        padding: 9px 13px;
        border: 0;
        border-radius: 9px;
        color: #fff;
        background: rgba(255, 255, 255, .18);
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .invoice-edit-page .btn-add-product:hover {
        background: #fff;
        color: var(--edit-primary);
    }

    .invoice-edit-page #quickProductResults {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        z-index: 1050;
        max-height: 320px;
        overflow-y: auto;
        overscroll-behavior: contain;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #fff;
        color: #111827;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .15);
    }

    .invoice-edit-page [hidden] {
        display: none !important;
    }

    .invoice-edit-page .quick-product-item {
        display: block;
        width: 100%;
        padding: 12px 14px;
        border: 0;
        border-bottom: 1px solid #eee;
        background: #fff;
        text-align: left;
        cursor: pointer;
    }

    .invoice-edit-page .quick-product-item:hover,
    .invoice-edit-page .quick-product-item.is-active {
        background: #eef2ff;
    }

    .invoice-edit-page .quick-product-name {
        display: block;
        color: #111827;
        font-weight: 600;
    }

    .invoice-edit-page .quick-product-price {
        display: block;
        margin-top: 4px;
        color: var(--edit-primary);
        font-size: 13px;
    }

    .invoice-edit-page .product-table-wrapper {
        overflow-x: auto;
        border-radius: 0 0 18px 18px;
    }

    .invoice-edit-page .product-table {
        width: 100%;
        min-width: 760px;
        margin: 0;
    }

    .invoice-edit-page .product-table th {
        padding: 13px 14px;
        border-bottom: 1px solid #e9ebf0;
        background: #f8f9fc;
        color: #6b7280;
        font-size: 12px;
        white-space: nowrap;
    }

    .invoice-edit-page .product-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f0f1f4;
        vertical-align: middle;
    }

    .invoice-edit-page .unit-price-display {
        background: #f8f9fc;
        font-weight: 600;
    }

    .invoice-edit-page .line-total {
        color: var(--edit-primary);
        font-weight: 750;
        white-space: nowrap;
    }

    .invoice-edit-page .btn-delete-product {
        width: 35px;
        height: 35px;
        border: 0;
        border-radius: 9px;
        background: #fef2f2;
        color: #dc2626;
    }

    .invoice-edit-page .payment-card {
        margin-top: 20px;
    }

    .invoice-edit-page .payment-content {
        padding: 24px;
    }

    .invoice-edit-page .payment-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
        color: var(--edit-primary);
        font-size: 15px;
        font-weight: 750;
    }

    .invoice-edit-page .payment-title-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #eeecff;
    }

    .invoice-edit-page .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 7px 0;
        color: #4b5563;
        font-size: 14px;
    }

    .invoice-edit-page .summary-row.discount {
        color: #ef4444;
    }

    .invoice-edit-page .summary-row.fee {
        color: #059669;
    }

    .invoice-edit-page .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 5px;
        padding: 17px 0;
        border-top: 1px dashed #dfe2e8;
        border-bottom: 1px dashed #dfe2e8;
        font-weight: 800;
    }

    .invoice-edit-page .summary-total strong {
        color: var(--edit-primary);
        font-size: 24px;
    }

    .invoice-edit-page .deposit-row {
        display: flex;
        justify-content: space-between;
        padding: 13px 0;
        color: #059669;
    }

    .invoice-edit-page .remaining-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 10px;
        padding: 14px 16px;
        border-radius: 12px;
        background: #ecfdf5;
        color: #047857;
    }

    .invoice-edit-page #remainingLabel {
        font-size: 12px;
        font-weight: 800;
    }

    .invoice-edit-page #remainingDisplay {
        font-size: 18px;
        font-weight: 800;
    }

    .invoice-edit-page .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
    }

    .invoice-edit-page .btn-save {
        padding: 11px 22px;
        border: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, #635bff, #764ba2);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 7px 18px rgba(99, 91, 255, .22);
    }

    .invoice-edit-page .btn-save:disabled {
        opacity: .65;
        cursor: wait;
    }

    @media (max-width: 991px) {
        .invoice-edit-page {
            padding: 20px 15px;
        }
    }

    @media (max-width: 575px) {
        .invoice-edit-page .page-top {
            flex-direction: column;
            align-items: stretch;
        }

        .invoice-edit-page .page-title h2 {
            font-size: 21px;
        }

        .invoice-edit-page .modern-card-body,
        .invoice-edit-page .payment-content {
            padding: 17px;
        }

        .invoice-edit-page .product-search-bar {
            flex-basis: 100%;
        }

        .invoice-edit-page .product-search-box {
            min-width: 0;
            flex-basis: 100%;
        }

        .invoice-edit-page .form-actions {
            flex-direction: column-reverse;
        }

        .invoice-edit-page .summary-total strong {
            font-size: 20px;
        }
    }
</style>

<div class="invoice-edit-page">

    <div class="page-top">
        <div class="page-title-wrapper">
            <div class="page-title-icon">
                <i class="bi bi-pencil-square"></i>
            </div>

            <div class="page-title">
                <h2>Chỉnh sửa hóa đơn</h2>
                <p>Cập nhật khách hàng, sản phẩm và thanh toán</p>
            </div>
        </div>

        <a
            href="{{ route('invoices.show', $invoice) }}"
            class="btn-back"
        >
            <i class="bi bi-arrow-left"></i>
            Quay lại hóa đơn
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Chưa lưu được hóa đơn:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        id="invoiceForm"
        method="POST"
        action="{{ route('invoices.update', $invoice) }}"
    >
        @csrf
        @method('PUT')

        <input
            type="hidden"
            name="invoice_version"
            value="{{ old('invoice_version', $invoice->updated_at?->format('Y-m-d H:i:s.u')) }}"
        >

        <input
            type="hidden"
            name="lead_id"
            id="lead_id"
            value="{{ $formValue('lead_id') }}"
        >

        <div class="row g-4">

            {{-- THÔNG TIN KHÁCH HÀNG --}}
            <div class="col-lg-4">
                <div class="modern-card">
                    <div class="modern-card-header blue">
                        <div class="card-heading">
                            <span class="card-heading-icon">
                                <i class="bi bi-person"></i>
                            </span>

                            Thông tin khách hàng
                        </div>
                    </div>

                    <div class="modern-card-body">

                        <div class="form-group">
                            <label
                                for="sale_name"
                                class="form-label-modern"
                            >
                                Tên Sale <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="sale_name"
                                id="sale_name"
                                class="form-control"
                                value="{{ $formValue('sale_name') }}"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label
                                for="showroom_id"
                                class="form-label-modern"
                            >
                                Showroom <span class="required">*</span>
                            </label>

                            <select
                                name="showroom_id"
                                id="showroom_id"
                                class="form-select"
                                required
                            >
                                <option value="">-- Chọn Showroom --</option>

                                @foreach($showrooms as $showroom)
                                    <option
                                        value="{{ $showroom->id }}"
                                        {{ (string) $formValue('showroom_id') === (string) $showroom->id ? 'selected' : '' }}
                                    >
                                        {{ $showroom->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label
                                for="search_phone"
                                class="form-label-modern"
                            >
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
                                    value="{{ $formValue('customer_phone') }}"
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

                        <div
                            id="searchLoading"
                            class="small text-primary mb-3"
                            role="status"
                            hidden
                        >
                            Đang tìm khách hàng...
                        </div>

                        <div id="leadResults" class="mb-3" hidden></div>

                        <div class="form-group">
                            <label
                                for="customer_name"
                                class="form-label-modern"
                            >
                                Khách hàng <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                id="customer_name"
                                class="form-control"
                                value="{{ $formValue('customer_name') }}"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label
                                for="customer_phone"
                                class="form-label-modern"
                            >
                                Số điện thoại <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="customer_phone"
                                id="customer_phone"
                                class="form-control"
                                value="{{ $formValue('customer_phone') }}"
                                maxlength="50"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label
                                for="customer_address"
                                class="form-label-modern"
                            >
                                Địa chỉ giao hàng
                            </label>

                            <textarea
                                name="customer_address"
                                id="customer_address"
                                class="form-control"
                                rows="3"
                                maxlength="1000"
                            >{{ $formValue('customer_address') }}</textarea>
                        </div>

                        <div
                            id="selectedLeadBox"
                            class="selected-lead mb-3"
                            @if(!$formValue('lead_id')) hidden @endif
                        >
                            <i class="bi bi-check-circle-fill"></i>
                            Lead đang chọn:
                            <strong id="selectedLeadId">
                                #{{ $formValue('lead_id') }}
                            </strong>
                        </div>

                        <div>
                            <label
                                for="invoice_note"
                                class="form-label-modern"
                            >
                                <i class="bi bi-chat-left-text"></i>
                                Ghi chú
                            </label>

                            <textarea
                                name="note"
                                id="invoice_note"
                                class="form-control"
                                rows="3"
                                maxlength="5000"
                            >{{ $formValue('note') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- SẢN PHẨM VÀ THANH TOÁN --}}
            <div class="col-lg-8">

                <div class="modern-card product-search-card">
                    <div class="modern-card-header gradient">
                        <div class="card-heading">
                            <span class="card-heading-icon">
                                <i class="bi bi-box-seam"></i>
                            </span>

                            Danh sách sản phẩm
                        </div>

                        <div class="product-search-bar">
                            <div class="product-search-box">
                                <input
                                    type="text"
                                    id="quickProductSearch"
                                    class="form-control"
                                    placeholder="Gõ tên sản phẩm để tìm..."
                                    autocomplete="off"
                                    aria-label="Tìm sản phẩm"
                                    role="combobox"
                                    aria-autocomplete="list"
                                    aria-controls="quickProductResults"
                                    aria-expanded="false"
                                >

                                <div
                                    id="quickProductResults"
                                    role="listbox"
                                    aria-label="Kết quả tìm sản phẩm"
                                    hidden
                                ></div>
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
                    </div>

                    <div class="product-table-wrapper">
                        <table class="table product-table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center" style="width:100px">
                                        SL
                                    </th>
                                    <th class="text-end">Thành tiền</th>
                                    <th style="width:60px"></th>
                                </tr>
                            </thead>

                            <tbody id="itemsBody"></tbody>
                        </table>
                    </div>
                </div>

                <div class="modern-card payment-card">
                    <div class="payment-content">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="payment-title">
                                    <span class="payment-title-icon">
                                        <i class="bi bi-sliders"></i>
                                    </span>

                                    Chiết khấu & Chi phí
                                </div>

                                <div class="form-group">
                                    <label
                                        for="discount_amount"
                                        class="form-label-modern"
                                    >
                                        Chiết khấu
                                    </label>

                                    <input
                                        type="number"
                                        name="discount_amount"
                                        id="discount_amount"
                                        class="form-control calculate-trigger"
                                        min="0"
                                        max="999999999999"
                                        step="1"
                                        value="{{ $formValue('discount_amount', 0) }}"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label
                                        for="other_discount"
                                        class="form-label-modern"
                                    >
                                        Chiết khấu khác
                                    </label>

                                    <input
                                        type="number"
                                        name="other_discount"
                                        id="other_discount"
                                        class="form-control calculate-trigger"
                                        min="0"
                                        max="999999999999"
                                        step="1"
                                        value="{{ $formValue('other_discount', 0) }}"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label
                                        for="other_fee"
                                        class="form-label-modern"
                                    >
                                        Phí khác
                                    </label>

                                    <input
                                        type="number"
                                        name="other_fee"
                                        id="other_fee"
                                        class="form-control calculate-trigger"
                                        min="0"
                                        max="999999999999"
                                        step="1"
                                        value="{{ $formValue('other_fee', 0) }}"
                                        required
                                    >
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label
                                            for="deposit_amount"
                                            class="form-label-modern"
                                        >
                                            Tiền cọc
                                        </label>

                                        <input
                                            type="number"
                                            name="deposit_amount"
                                            id="deposit_amount"
                                            class="form-control calculate-trigger"
                                            min="0"
                                            max="999999999999"
                                            step="1"
                                            value="{{ $formValue('deposit_amount', 0) }}"
                                            required
                                        >
                                    </div>

                                    <div class="col-6">
                                        <label
                                            for="deposit_type"
                                            class="form-label-modern"
                                        >
                                            Hình thức cọc
                                        </label>
                                        <select
                                            name="deposit_type"
                                            id="deposit_type"
                                            class="form-select"
                                        >
                                            @foreach([
                                                'Trống',
                                                'Chuyển khoản',
                                                'Tiền mặt',
                                                'Quẹt thẻ',
                                                'Tiền Mặt + Chuyển Khoản',
                                                'Chuyển Khoản + Quẹt Thẻ',
                                                'Tiền Mặt + Quẹt Thẻ'
                                            ] as $method)
                                                <option
                                                    value="{{ $method }}"
                                                    {{ ($formValue('deposit_type') ?: '-') === $method ? 'selected' : '' }}
                                                >
                                                    {{ $method === '-' ? '— Để trống —' : $method }}
                                                </option>
                                            @endforeach
                                        </select>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="payment-title">
                                    <span class="payment-title-icon">
                                        <i class="bi bi-calculator"></i>
                                    </span>

                                    Tổng kết thanh toán
                                </div>

                                <div class="summary-row">
                                    <span>Tổng tiền sản phẩm</span>
                                    <strong id="itemsTotalDisplay">0 ₫</strong>
                                </div>

                                <div class="summary-row discount">
                                    <span>Chiết khấu hóa đơn</span>
                                    <strong id="discountDisplay">0 ₫</strong>
                                </div>

                                <div class="summary-row discount">
                                    <span>Chiết khấu khác</span>
                                    <strong id="otherDiscountDisplay">0 ₫</strong>
                                </div>

                                <div class="summary-row fee">
                                    <span>Phí khác</span>
                                    <strong id="otherFeeDisplay">0 ₫</strong>
                                </div>

                                <div class="summary-total">
                                    <span>TỔNG THANH TOÁN</span>
                                    <strong id="grandTotalDisplay">0 ₫</strong>
                                </div>

                                <div class="deposit-row">
                                    <span>
                                        <i class="bi bi-wallet2"></i>
                                        Đã cọc
                                    </span>

                                    <strong id="depositDisplay">0 ₫</strong>
                                </div>

                                <div class="remaining-box" aria-live="polite">
                                    <span id="remainingLabel">
                                        CÒN LẠI PHẢI THU:
                                    </span>

                                    <strong id="remainingDisplay">0 ₫</strong>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a
                        href="{{ route('invoices.show', $invoice) }}"
                        class="btn-cancel"
                    >
                        Hủy
                    </a>

                    <button
                        type="submit"
                        class="btn-save"
                        id="saveInvoiceBtn"
                    >
                        <i class="bi bi-check2-circle"></i>
                        LƯU THAY ĐỔI
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<template id="invoiceItemTemplate">
    <tr>
        <td>
            <input
                type="hidden"
                class="invoice-item-id"
                data-field="id"
            >

            <select
                class="form-select product-select"
                data-field="product_id"
                aria-label="Sản phẩm"
                required
            ></select>
        </td>

        <td class="text-end">
            <input
                type="text"
                class="form-control text-end unit-price-display"
                aria-label="Đơn giá"
                readonly
            >

            <input
                type="hidden"
                class="unit-price"
                data-field="unit_price"
            >
        </td>

        <td>
            <input
                type="number"
                class="form-control text-center quantity"
                data-field="quantity"
                aria-label="Số lượng"
                min="0.01"
                max="1000000"
                step="0.01"
                required
            >
        </td>

        <td class="text-end">
            <span class="line-total">0 ₫</span>
        </td>

        <td class="text-center">
            <button
                type="button"
                class="btn-delete-product remove-item"
                aria-label="Xóa sản phẩm"
            >
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const products = @json($catalogProducts);
    const initialItems = @json($initialItems);
    const leadSearchUrl = @json($leadSearchUrl);

    const form = document.getElementById('invoiceForm');
    const itemsBody = document.getElementById('itemsBody');
    const template = document.getElementById('invoiceItemTemplate');

    const quickSearch = document.getElementById('quickProductSearch');
    const quickResults = document.getElementById('quickProductResults');

    const searchPhone = document.getElementById('search_phone');
    const searchButton = document.getElementById('searchPhoneBtn');
    const searchLoading = document.getElementById('searchLoading');
    const leadResults = document.getElementById('leadResults');

    let activeProductIndex = -1;
    let leadSearchController = null;

    const money = function (value) {
        return new Intl.NumberFormat('vi-VN', {
            maximumFractionDigits: 0
        }).format(Number(value) || 0) + ' ₫';
    };

    function readNumber(input) {
        const value = Number(input.value);
        return Number.isFinite(value) ? Math.max(0, value) : 0;
    }

    function normalize(value) {
        return String(value ?? '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[đĐ]/g, 'd')
            .toLowerCase()
            .replace(/\s+/g, ' ')
            .trim();
    }

    function reindexRows() {
        itemsBody.querySelectorAll('tr').forEach(function (row, index) {
            row.querySelectorAll('[data-field]').forEach(function (input) {
                input.name = `items[${index}][${input.dataset.field}]`;
            });
        });
    }

    function calculateTotals() {
        let subtotal = 0;

        itemsBody.querySelectorAll('tr').forEach(function (row) {
            const price = readNumber(row.querySelector('.unit-price'));
            const quantity = readNumber(row.querySelector('.quantity'));
            const total = Math.round(price * quantity);

            row.querySelector('.line-total').textContent = money(total);
            subtotal += total;
        });

        const discount = Math.round(readNumber(
            document.getElementById('discount_amount')
        ));

        const otherDiscount = Math.round(readNumber(
            document.getElementById('other_discount')
        ));

        const fee = Math.round(readNumber(
            document.getElementById('other_fee')
        ));

        const deposit = Math.round(readNumber(
            document.getElementById('deposit_amount')
        ));

        const grandTotal = Math.max(
            0,
            subtotal - discount - otherDiscount + fee
        );

        const difference = grandTotal - deposit;

        document.getElementById('itemsTotalDisplay').textContent =
            money(subtotal);

        document.getElementById('discountDisplay').textContent =
            '- ' + money(discount);

        document.getElementById('otherDiscountDisplay').textContent =
            '- ' + money(otherDiscount);

        document.getElementById('otherFeeDisplay').textContent =
            '+ ' + money(fee);

        document.getElementById('grandTotalDisplay').textContent =
            money(grandTotal);

        document.getElementById('depositDisplay').textContent =
            money(deposit);

        const label = document.getElementById('remainingLabel');
        const display = document.getElementById('remainingDisplay');

        label.textContent = difference < 0
            ? 'TIỀN CỌC DƯ:'
            : 'CÒN LẠI PHẢI THU:';

        display.textContent = difference === 0
            ? '0 ₫ (Đã đủ)'
            : money(Math.abs(difference));

        label.classList.toggle('text-primary', difference < 0);
        display.classList.toggle('text-primary', difference < 0);
    }

    function addItem(item = {}, focus = false) {
        if (itemsBody.children.length >= 200) {
            alert('Mỗi hóa đơn tối đa 200 dòng sản phẩm.');
            return;
        }

        const fragment = template.content.cloneNode(true);
        const row = fragment.querySelector('tr');

        const select = row.querySelector('.product-select');
        const idInput = row.querySelector('.invoice-item-id');
        const priceInput = row.querySelector('.unit-price');
        const priceDisplay = row.querySelector('.unit-price-display');
        const quantityInput = row.querySelector('.quantity');

        idInput.value = item.id ?? '';

        select.add(new Option('-- Chọn sản phẩm --', ''));

        products.forEach(function (product) {
            const option = new Option(product.name, product.id);
            option.dataset.price = Number(product.price) || 0;
            select.add(option);
        });

        const productId = item.product_id ?? '';

        const catalogProduct = products.find(function (product) {
            return String(product.id) === String(productId);
        });

        // Giữ sản phẩm cũ ngay cả khi không còn trong danh mục chọn mới.
        if (productId && !catalogProduct) {
            const option = new Option(
                item.product_name || 'Sản phẩm đã lưu',
                productId
            );

            option.dataset.price = Number(item.unit_price) || 0;
            select.add(option);
        }

        select.value = String(productId);

        // Nạp giá đã bán; không tự đổi sang giá danh mục hiện tại.
        const savedPrice = Number(item.unit_price);

        const price = (
            item.unit_price !== null &&
            item.unit_price !== undefined &&
            item.unit_price !== '' &&
            Number.isFinite(savedPrice)
        )
            ? savedPrice
            : Number(catalogProduct?.price) || 0;

        priceInput.value = price;
        priceDisplay.value = money(price);
        quantityInput.value = item.quantity ?? 1;

        select.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            const selectedPrice = Number(option?.dataset.price) || 0;

            priceInput.value = selectedPrice;
            priceDisplay.value = money(selectedPrice);

            calculateTotals();
        });

        quantityInput.addEventListener('input', calculateTotals);

        row.querySelector('.remove-item').addEventListener('click', function () {
            if (itemsBody.children.length <= 1) {
                alert('Hóa đơn phải có ít nhất một sản phẩm.');
                return;
            }

            row.remove();
            reindexRows();
            calculateTotals();
        });

        itemsBody.appendChild(fragment);

        reindexRows();
        calculateTotals();

        if (focus) {
            select.focus();
        }
    }

    function hideProductResults() {
        quickResults.hidden = true;
        quickResults.replaceChildren();
        activeProductIndex = -1;

        quickSearch.setAttribute('aria-expanded', 'false');
        quickSearch.removeAttribute('aria-activedescendant');
    }

    function chooseProduct(product) {
        const emptySelect = Array.from(
            itemsBody.querySelectorAll('.product-select')
        ).find(function (select) {
            return !select.value;
        });

        if (emptySelect) {
            emptySelect.value = String(product.id);
            emptySelect.dispatchEvent(new Event('change'));
        } else {
            if (itemsBody.children.length >= 200) {
                alert('Mỗi hóa đơn tối đa 200 dòng sản phẩm.');
                return;
            }

            addItem({
                product_id: product.id,
                quantity: 1
            });
        }

        quickSearch.value = '';
        hideProductResults();
        quickSearch.focus();
    }

    function renderProductResults() {
        const keyword = normalize(quickSearch.value);
        const words = keyword ? keyword.split(' ') : [];

        hideProductResults();

        const matches = products.filter(function (product) {
            const name = normalize(product.name);

            return words.every(function (word) {
                return name.includes(word);
            });
        });

        quickResults.hidden = false;
        quickSearch.setAttribute('aria-expanded', 'true');

        if (!matches.length) {
            const message = document.createElement('div');
            message.className = 'p-3 text-muted';
            message.textContent = 'Không tìm thấy sản phẩm.';
            quickResults.appendChild(message);
            return;
        }

        const fragment = document.createDocumentFragment();

        matches.forEach(function (product, index) {
            const button = document.createElement('button');

            button.type = 'button';
            button.className = 'quick-product-item';
            button.id = 'edit-product-option-' + index;
            button.tabIndex = -1;

            button.setAttribute('role', 'option');
            button.setAttribute('aria-selected', 'false');

            const name = document.createElement('span');
            name.className = 'quick-product-name';
            name.textContent = product.name;

            const price = document.createElement('span');
            price.className = 'quick-product-price';
            price.textContent = money(product.price);

            button.append(name, price);

            button.addEventListener('mousedown', function (event) {
                event.preventDefault();
            });

            button.addEventListener('click', function () {
                chooseProduct(product);
            });

            fragment.appendChild(button);
        });

        quickResults.appendChild(fragment);
    }

    function setActiveProduct(index) {
        const buttons = Array.from(
            quickResults.querySelectorAll('.quick-product-item')
        );

        if (!buttons.length) {
            return;
        }

        activeProductIndex = Math.max(
            0,
            Math.min(index, buttons.length - 1)
        );

        buttons.forEach(function (button, buttonIndex) {
            const active = buttonIndex === activeProductIndex;

            button.classList.toggle('is-active', active);
            button.setAttribute('aria-selected', String(active));
        });

        const activeButton = buttons[activeProductIndex];

        quickSearch.setAttribute(
            'aria-activedescendant',
            activeButton.id
        );

        activeButton.scrollIntoView({
            block: 'nearest'
        });
    }

    quickSearch.addEventListener('input', renderProductResults);
    quickSearch.addEventListener('focus', renderProductResults);

    quickSearch.addEventListener('click', function () {
        if (quickResults.hidden) {
            renderProductResults();
        }
    });

    quickSearch.addEventListener('keydown', function (event) {
        if (event.isComposing) {
            return;
        }

        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            event.preventDefault();

            if (quickResults.hidden) {
                renderProductResults();
            }

            const buttons = quickResults.querySelectorAll(
                '.quick-product-item'
            );

            if (!buttons.length) {
                return;
            }

            const nextIndex = activeProductIndex < 0
                ? (event.key === 'ArrowDown' ? 0 : buttons.length - 1)
                : activeProductIndex + (
                    event.key === 'ArrowDown' ? 1 : -1
                );

            setActiveProduct(nextIndex);
            return;
        }

        if (event.key === 'Enter') {
            event.preventDefault();

            if (quickResults.hidden) {
                renderProductResults();
                return;
            }

            const buttons = quickResults.querySelectorAll(
                '.quick-product-item'
            );

            buttons[Math.max(0, activeProductIndex)]?.click();
            return;
        }

        if (event.key === 'Escape' || event.key === 'Tab') {
            hideProductResults();
        }
    });

    document.addEventListener('click', function (event) {
        if (!quickSearch.parentElement.contains(event.target)) {
            hideProductResults();
        }
    });

    function selectLead(lead) {
        document.getElementById('lead_id').value = lead.id ?? '';

        document.getElementById('customer_name').value =
            lead.name ?? lead.customer_name ?? '';

        document.getElementById('customer_phone').value =
            lead.phone || searchPhone.value.trim();

        document.getElementById('customer_address').value =
            lead.address ?? '';

        document.getElementById('selectedLeadId').textContent =
            '#' + (lead.id ?? '');

        document.getElementById('selectedLeadBox').hidden = false;

        searchPhone.value = lead.phone || searchPhone.value.trim();

        leadResults.hidden = true;
        leadResults.replaceChildren();
    }

    async function searchLead() {
        const phone = searchPhone.value.trim();

        if (phone.length < 6) {
            alert('Vui lòng nhập ít nhất 6 số điện thoại.');
            return;
        }

        leadSearchController?.abort();

        const controller = new AbortController();
        leadSearchController = controller;

        searchLoading.hidden = false;
        leadResults.hidden = true;
        leadResults.replaceChildren();

        try {
            const url = new URL(leadSearchUrl, location.origin);
            url.searchParams.set('phone', phone);

            const response = await fetch(url, {
                method: 'GET',
                signal: controller.signal,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Không thể tìm khách hàng.');
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(
                    data.message || 'Không thể tìm khách hàng.'
                );
            }

            const leads = Array.isArray(data.leads) ? data.leads : [];

            if (leads.length === 1) {
                selectLead(leads[0]);
                return;
            }

            leadResults.hidden = false;

            if (!leads.length) {
                const message = document.createElement('div');
                message.className = 'alert alert-warning mb-0';
                message.textContent =
                    'Không tìm thấy khách hàng có số điện thoại: ' + phone;

                leadResults.appendChild(message);
                return;
            }

            leads.forEach(function (lead) {
                const button = document.createElement('button');

                button.type = 'button';
                button.className = 'lead-option';

                const name = document.createElement('strong');
                name.textContent =
                    (lead.name || lead.customer_name || 'Chưa có tên') +
                    ' — #' + lead.id;

                const phoneLine = document.createElement('div');
                phoneLine.className = 'small mt-1';
                phoneLine.textContent = lead.phone || phone;

                const address = document.createElement('div');
                address.className = 'small text-muted mt-1';
                address.textContent =
                    lead.address || 'Chưa có địa chỉ';

                button.append(name, phoneLine, address);

                button.addEventListener('click', function () {
                    selectLead(lead);
                });

                leadResults.appendChild(button);
            });
        } catch (error) {
            if (error.name !== 'AbortError') {
                alert(error.message || 'Có lỗi khi tìm khách hàng.');
            }
        } finally {
            if (leadSearchController === controller) {
                searchLoading.hidden = true;
            }
        }
    }

    searchButton.addEventListener('click', searchLead);

    searchPhone.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchLead();
        }
    });

    document.getElementById('addItemBtn')
        .addEventListener('click', function () {
            addItem({}, true);
        });

    document.querySelectorAll('.calculate-trigger')
        .forEach(function (input) {
            input.addEventListener('input', calculateTotals);
        });

    const restoredItems = Object.values(initialItems || {});

    if (restoredItems.length) {
        restoredItems.forEach(function (item) {
            addItem(item);
        });
    } else {
        addItem();
    }

    form.addEventListener('submit', function () {
        reindexRows();

        const button = document.getElementById('saveInvoiceBtn');
        button.disabled = true;
        button.textContent = 'Đang lưu...';
    });

    calculateTotals();
});
</script>

@endsection