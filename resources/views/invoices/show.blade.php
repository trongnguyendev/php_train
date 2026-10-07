@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       MODERN INVOICE DETAIL
    ========================================================= */

    :root {
        --invoice-primary: #635bff;
        --invoice-primary-dark: #4f46e5;
        --invoice-secondary: #8b5cf6;
        --invoice-blue: #2563eb;
        --invoice-green: #16a34a;
        --invoice-red: #ef4444;
        --invoice-orange: #f59e0b;
        --invoice-dark: #172033;
        --invoice-muted: #64748b;
        --invoice-bg: #f5f7fb;
        --invoice-border: #e8ebf2;
    }

    /* PAGE */
    .invoice-detail-page {
        min-height: 100vh;
        background:
            radial-gradient(circle at 10% 10%, rgba(99, 91, 255, .08), transparent 30%),
            radial-gradient(circle at 90% 5%, rgba(139, 92, 246, .08), transparent 25%),
            #f5f7fb;
        padding: 28px 0 50px;
    }

    /* =========================================================
       TOP HEADER
    ========================================================= */

    .invoice-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .invoice-page-title-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .invoice-title-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 25px;
        background: linear-gradient(
            135deg,
            var(--invoice-primary),
            var(--invoice-secondary)
        );
        box-shadow: 0 10px 25px rgba(99, 91, 255, .25);
    }

    .invoice-page-title {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: var(--invoice-dark);
        letter-spacing: -.4px;
    }

    .invoice-page-subtitle {
        margin-top: 5px;
        color: var(--invoice-muted);
        font-size: 14px;
    }

    .invoice-code-highlight {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        background: #eef2ff;
        color: var(--invoice-primary-dark);
        font-weight: 700;
    }

    /* BUTTONS */

    .invoice-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-modern {
        border: 0;
        border-radius: 11px;
        padding: 11px 17px;
        font-weight: 700;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
    }

    .btn-invoice-print {
        color: #fff;
        background: linear-gradient(
            135deg,
            var(--invoice-primary),
            var(--invoice-secondary)
        );
        box-shadow: 0 7px 18px rgba(99, 91, 255, .22);
    }

    .btn-invoice-print:hover {
        color: #fff;
        box-shadow: 0 10px 25px rgba(99, 91, 255, .3);
    }

    .btn-invoice-back {
        color: #475569;
        background: #fff;
        border: 1px solid var(--invoice-border);
    }

    .btn-invoice-back:hover {
        color: var(--invoice-dark);
        background: #f8fafc;
    }

    /* =========================================================
       QUICK INFO CARDS
    ========================================================= */

    .invoice-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 25px;
    }

    .invoice-info-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--invoice-border);
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .045);
        transition: all .2s ease;
    }

    .invoice-info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
    }

    .invoice-info-card::after {
        content: "";
        position: absolute;
        width: 70px;
        height: 70px;
        right: -25px;
        bottom: -25px;
        border-radius: 50%;
        background: rgba(99, 91, 255, .06);
    }

    .invoice-info-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 18px;
    }

    .invoice-icon-purple {
        background: #eef2ff;
        color: #635bff;
    }

    .invoice-icon-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .invoice-icon-green {
        background: #ecfdf5;
        color: #16a34a;
    }

    .invoice-icon-orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .invoice-info-label {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 4px;
    }

    .invoice-info-value {
        color: var(--invoice-dark);
        font-size: 15px;
        font-weight: 800;
    }

    /* =========================================================
       MAIN CONTENT
    ========================================================= */

    .invoice-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
        align-items: start;
    }

    .invoice-content-card {
        background: #fff;
        border: 1px solid var(--invoice-border);
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .055);
        overflow: hidden;
    }

    .invoice-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid var(--invoice-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .invoice-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: var(--invoice-dark);
        margin: 0;
    }

    .invoice-card-title i {
        color: var(--invoice-primary);
    }

    /* =========================================================
       CUSTOMER CARD
    ========================================================= */

    .customer-card-body {
        padding: 22px;
    }

    .customer-profile {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .customer-avatar {
        width: 58px;
        height: 58px;
        flex-shrink: 0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        font-weight: 800;
        background: linear-gradient(
            135deg,
            #2563eb,
            #7c3aed
        );
        box-shadow: 0 8px 18px rgba(37, 99, 235, .2);
    }

    .customer-name {
        color: var(--invoice-dark);
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .customer-subtitle {
        color: var(--invoice-muted);
        font-size: 13px;
    }

    .customer-detail-list {
        display: flex;
        flex-direction: column;
        gap: 13px;
    }

    .customer-detail-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        color: #475569;
        font-size: 13px;
    }

    .customer-detail-item i {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        background: #f1f5f9;
        color: var(--invoice-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .customer-detail-label {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        margin-bottom: 2px;
    }

    .customer-detail-value {
        color: #334155;
        font-weight: 600;
    }

    /* =========================================================
       PRODUCT TABLE
    ========================================================= */

    .invoice-product-wrapper {
        padding: 0;
    }

    .modern-product-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-product-table thead th {
        padding: 14px 18px;
        background: #f8fafc;
        color: #64748b;
        border-bottom: 1px solid var(--invoice-border);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .6px;
        font-weight: 800;
        white-space: nowrap;
    }

    .modern-product-table tbody td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #334155;
        font-size: 13px;
        vertical-align: middle;
    }

    .modern-product-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .modern-product-table tbody tr {
        transition: background .2s ease;
    }

    .modern-product-table tbody tr:hover {
        background: #fafbff;
    }

    .product-number {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: var(--invoice-primary);
        font-weight: 800;
        font-size: 12px;
    }

    .product-name {
        font-weight: 750;
        color: #1e293b;
        font-size: 14px;
    }

    .product-price {
        font-weight: 700;
        color: #475569;
    }

    .product-quantity {
        min-width: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 7px;
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
    }

    .product-total {
        color: var(--invoice-primary-dark);
        font-weight: 800;
    }

    /* =========================================================
       PAYMENT SUMMARY
    ========================================================= */

    .payment-card {
        position: sticky;
        top: 20px;
    }

    .payment-card-body {
        padding: 20px;
    }

    .payment-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding: 12px 13px;
        border-radius: 12px;
        background: #ecfdf5;
        border: 1px solid #d1fae5;
    }

    .payment-status-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    .payment-status-value {
        color: #15803d;
        font-size: 12px;
        font-weight: 800;
    }

    .payment-status-dot {
        width: 8px;
        height: 8px;
        display: inline-block;
        border-radius: 50%;
        background: #22c55e;
        margin-right: 5px;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, .1);
    }

    .payment-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 0;
        font-size: 13px;
    }

    .payment-row-label {
        color: #64748b;
    }

    .payment-row-value {
        color: #334155;
        font-weight: 700;
        text-align: right;
    }

    .payment-row.discount .payment-row-value {
        color: #ef4444;
    }

    .payment-row.fee .payment-row-value {
        color: #16a34a;
    }

    .payment-divider {
        border: 0;
        border-top: 1px dashed #dbe1ea;
        margin: 10px 0;
    }

    .payment-grand-total {
        margin: 15px 0;
        padding: 18px;
        border-radius: 14px;
        background:
            linear-gradient(
                135deg,
                rgba(99, 91, 255, .1),
                rgba(139, 92, 246, .07)
            );
        border: 1px solid rgba(99, 91, 255, .12);
    }

    .payment-grand-label {
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .6px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .payment-grand-value {
        color: var(--invoice-primary-dark);
        font-size: 25px;
        line-height: 1.2;
        font-weight: 900;
    }

    .payment-deposit {
        color: #15803d;
    }

    .payment-remaining {
        margin-top: 14px;
        padding: 15px;
        border-radius: 13px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
    }

    .payment-remaining-label {
        color: #9a3412;
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: .5px;
        margin-bottom: 3px;
    }

    .payment-remaining-value {
        color: #ea580c;
        font-size: 20px;
        font-weight: 900;
    }

    /* =========================================================
       NOTE
    ========================================================= */

    .invoice-note-box {
        margin-top: 18px;
        padding: 15px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid var(--invoice-border);
    }

    .invoice-note-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #475569;
        font-weight: 800;
        font-size: 12px;
        margin-bottom: 7px;
    }

    .invoice-note-content {
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    /* =========================================================
       A4 PREVIEW
    ========================================================= */

    .invoice-preview-section {
        margin-top: 25px;
    }

    .invoice-preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 15px;
    }

    .invoice-preview-title {
        font-size: 17px;
        font-weight: 800;
        color: var(--invoice-dark);
        margin: 0;
    }

    .invoice-preview-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        font-size: 12px;
        background: #fff;
        padding: 7px 11px;
        border: 1px solid var(--invoice-border);
        border-radius: 8px;
    }

    .invoice-preview-card {
        background:
            linear-gradient(
                135deg,
                #eef2ff 0%,
                #f8fafc 45%,
                #f3e8ff 100%
            );
        padding: 30px;
        border-radius: 20px;
        border: 1px solid var(--invoice-border);
    }

    .invoice-paper {
        background: #ffffff;
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
        padding: 40px;
        box-shadow:
            0 20px 50px rgba(15, 23, 42, .12);
        border: 1px solid #e5e7eb;
        border-radius: 3px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        color: #000;
    }

    .invoice-paper * {
        box-sizing: border-box;
    }

    /* PRINT HEADER */

    .inv-header {
        position: relative;
        min-height: 180px;
        margin-bottom: 20px;
    }

    .inv-header-left {
        width: 55%;
        float: left;
        line-height: 1.45;
    }

    .logo {
        max-height: 55px;
        max-width: 180px;
        margin-bottom: 8px;
        display: block;
    }

    .inv-header-right {
        width: 45%;
        float: right;
        text-align: right;
        padding-top: 5px;
    }

    .inv-clear {
        clear: both;
    }

    .inv-title {
        font-size: 24px;
        font-weight: bold;
        color: #00008b;
        text-align: right;
        margin-bottom: 20px;
        letter-spacing: .5px;
    }

    .inv-date {
        font-style: italic;
        font-weight: bold;
        color: #0000cd;
        margin-bottom: 15px;
        font-size: 13.5px;
    }

    .inv-number {
        font-weight: bold;
        font-size: 14.5px;
        margin-bottom: 5px;
    }

    .inv-showroom {
        font-weight: bold;
        font-size: 13.5px;
    }

    .inv-region-title {
        font-weight: bold;
        font-size: 13px;
    }

    .inv-hotline {
        font-weight: bold;
        margin-top: 4px;
    }

    /* CUSTOMER */

    .inv-customer-info {
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .inv-customer-row {
        display: table;
        width: 100%;
        margin-bottom: 6px;
    }

    .inv-customer-label {
        display: table-cell;
        width: 130px;
        font-weight: bold;
        font-size: 13.5px;
        vertical-align: top;
    }

    .inv-customer-value {
        display: table-cell;
        font-weight: bold;
        font-size: 13.5px;
        vertical-align: top;
    }

    /* PRODUCT */

    .inv-product-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .inv-product-table th,
    .inv-product-table td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: middle;
    }

    .inv-product-table th {
        text-align: center;
        font-weight: bold;
        height: 32px;
        font-size: 13px;
        background-color: #fff;
    }

    .inv-col-stt {
        width: 6%;
    }

    .inv-col-product {
        width: 54%;
    }

    .inv-col-quantity {
        width: 10%;
    }

    .inv-col-price {
        width: 15%;
    }

    .inv-col-total {
        width: 15%;
    }

    .inv-center {
        text-align: center;
    }

    .inv-right {
        text-align: right;
    }

    .inv-product-name {
        text-align: left;
    }

    /* SUMMARY */

    .inv-summary-wrapper {
        width: 100%;
        margin-top: 15px;
        display: table;
        table-layout: fixed;
    }

    .inv-summary-note {
        display: table-cell;
        width: 60%;
        vertical-align: top;
        padding-right: 15px;
    }

    .inv-summary-box {
        display: table-cell;
        width: 40%;
        vertical-align: top;
    }

    .inv-summary-row {
        display: table;
        width: 100%;
        margin-bottom: 4px;
    }

    .inv-summary-label {
        display: table-cell;
        width: 55%;
        padding: 3px 0;
        text-align: right;
        font-weight: bold;
    }

    .inv-summary-value {
        display: table-cell;
        width: 45%;
        padding: 3px 0;
        text-align: right;
        font-weight: bold;
    }

    .inv-amount-word {
        margin-top: 40px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12.5px;
    }

    /* SIGNATURE */

    .inv-signature {
        width: 100%;
        margin-top: 40px;
        display: table;
        table-layout: fixed;
        text-align: center;
    }

    .inv-signature-column {
        display: table-cell;
        width: 50%;
        vertical-align: top;
    }

    .inv-signature-title {
        font-weight: bold;
        font-size: 13.5px;
    }

    .inv-signature-note {
        margin-top: 4px;
        font-size: 12.5px;
    }

    .inv-signature-space {
        height: 90px;
    }

    .inv-sale-name {
        font-weight: bold;
        font-size: 13.5px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1100px) {
        .invoice-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .invoice-layout {
            grid-template-columns: 1fr;
        }

        .payment-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .invoice-detail-page {
            padding: 18px 0 35px;
        }

        .invoice-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .invoice-page-title {
            font-size: 21px;
        }

        .invoice-title-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
        }

        .invoice-info-grid {
            grid-template-columns: 1fr;
        }

        .invoice-preview-card {
            padding: 10px;
        }

        .invoice-paper {
            padding: 20px;
        }

        .invoice-card-header {
            padding: 15px;
        }

        .customer-card-body,
        .payment-card-body {
            padding: 16px;
        }

        .modern-product-table {
            min-width: 650px;
        }

        .invoice-product-wrapper {
            overflow-x: auto;
        }

        .invoice-actions {
            width: 100%;
        }

        .invoice-actions .btn-modern {
            flex: 1;
            justify-content: center;
        }
    }

    /* =========================================================
       PRINT
    ========================================================= */

    @media print {

        body {
            background: #fff !important;
        }

        .invoice-detail-page {
            padding: 0 !important;
            background: #fff !important;
        }

        .no-print,
        .invoice-page-header,
        .invoice-info-grid,
        .invoice-layout,
        .invoice-preview-header {
            display: none !important;
        }

        .invoice-preview-section {
            margin: 0 !important;
        }

        .invoice-preview-card {
            padding: 0 !important;
            background: #fff !important;
            border: 0 !important;
        }

        .invoice-paper {
            max-width: 100% !important;
            box-shadow: none !important;
            border: 0 !important;
            border-radius: 0 !important;
            padding: 20px !important;
        }
    }
</style>


<div class="invoice-detail-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <div class="invoice-page-header no-print">

            <div class="invoice-page-title-wrapper">

                <div class="invoice-title-icon">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>

                <div>
                    <h1 class="invoice-page-title">
                        Chi tiết hóa đơn
                    </h1>

                    <div class="invoice-page-subtitle">
                        Quản lý và kiểm tra thông tin hóa đơn
                        <span class="mx-1">•</span>

                        <span class="invoice-code-highlight">
                            <i class="bi bi-hash"></i>
                            {{ $invoice->invoice_code }}
                        </span>

                        <span class="ms-2">
                            {{ $invoice->created_at
                                ? $invoice->created_at->format('d/m/Y H:i')
                                : '' }}
                        </span>
                    </div>
                </div>

            </div>


            <div class="invoice-actions">

                <a
                    href="{{ route('invoices.print', $invoice) }}"
                    target="_blank"
                    class="btn-modern btn-invoice-print"
                >
                    <i class="bi bi-printer"></i>
                    In hóa đơn
                </a>

                <a
                    href="{{ route('invoices.index') }}"
                    class="btn-modern btn-invoice-back"
                >
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>

            </div>

        </div>


        {{-- =====================================================
             THÔNG TIN NHANH
        ====================================================== --}}

        @php
            $deposit = (float) (
                $invoice->deposit_amount
                ?? $invoice->deposit
                ?? $invoice->advance_payment
                ?? 0
            );

            $otherFee = (float) (
                $invoice->other_fee
                ?? 0
            );

            $discountManual = (float) (
                $invoice->discount_manual
                ?? $invoice->discount_amount
                ?? 0
            );

            $discountRetail = (float) (
                $invoice->discount_retail
                ?? $invoice->other_discount
                ?? 0
            );

            $discountTotal = (float) (
                $invoice->discount_total
                ?? 0
            );

            $discount = $discountTotal > 0
                ? $discountTotal
                : ($discountManual + $discountRetail);

            $subtotal = (float) (
                $invoice->subtotal
                ?? $invoice->items->sum('subtotal')
            );

            $grandTotal = (float) (
                $invoice->grand_total
                ?? max(0, $subtotal - $discount + $otherFee)
            );

            $remaining = (float) (
                $invoice->remaining
                ?? max(0, $grandTotal - $deposit)
            );

            $note = $invoice->note ?? '';

            $paymentMethod = $invoice->deposit_type
                ?: ($invoice->payment_method ?: 'Chuyển khoản');

            $customerName = $invoice->customer_name ?: 'Khách hàng';

            $avatarLetter = mb_strtoupper(
                mb_substr(trim($customerName), 0, 1, 'UTF-8'),
                'UTF-8'
            );
        @endphp


        <div class="invoice-info-grid no-print">

            {{-- CUSTOMER --}}
            <div class="invoice-info-card">

                <div class="invoice-info-icon invoice-icon-purple">
                    <i class="bi bi-person"></i>
                </div>

                <div class="invoice-info-label">
                    Khách hàng
                </div>

                <div class="invoice-info-value">
                    {{ $customerName }}
                </div>

            </div>


            {{-- PHONE --}}
            <div class="invoice-info-card">

                <div class="invoice-info-icon invoice-icon-blue">
                    <i class="bi bi-telephone"></i>
                </div>

                <div class="invoice-info-label">
                    Số điện thoại
                </div>

                <div class="invoice-info-value">
                    {{ $invoice->customer_phone ?: 'Chưa cập nhật' }}
                </div>

            </div>


            {{-- SHOWROOM --}}
            <div class="invoice-info-card">

                <div class="invoice-info-icon invoice-icon-green">
                    <i class="bi bi-shop"></i>
                </div>

                <div class="invoice-info-label">
                    Showroom
                </div>

                <div class="invoice-info-value">
                    {{ $invoice->showroom->name ?? 'Chưa chọn showroom' }}
                </div>

            </div>


            {{-- TOTAL --}}
            <div class="invoice-info-card">

                <div class="invoice-info-icon invoice-icon-orange">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div class="invoice-info-label">
                    Tổng thanh toán
                </div>

                <div class="invoice-info-value">
                    {{ number_format($grandTotal, 0, ',', '.') }} ₫
                </div>

            </div>

        </div>


        {{-- =====================================================
             MAIN
        ====================================================== --}}

        <div class="invoice-layout no-print">

            {{-- =================================================
                 LEFT
            ================================================== --}}

            <div>

                {{-- CUSTOMER --}}
                <div class="invoice-content-card mb-4">

                    <div class="invoice-card-header">

                        <h2 class="invoice-card-title">
                            <i class="bi bi-person-vcard"></i>
                            Thông tin khách hàng
                        </h2>

                    </div>


                    <div class="customer-card-body">

                        <div class="customer-profile">

                            <div class="customer-avatar">
                                {{ $avatarLetter }}
                            </div>

                            <div>

                                <div class="customer-name">
                                    {{ $customerName }}
                                </div>
                            </div>

                        </div>


                        <div class="customer-detail-list">

                            <div class="customer-detail-item">

                                <i class="bi bi-telephone"></i>

                                <div>
                                    <span class="customer-detail-label">
                                        Số điện thoại
                                    </span>

                                    <span class="customer-detail-value">
                                        {{ $invoice->customer_phone ?: 'Chưa cập nhật' }}
                                    </span>
                                </div>

                            </div>


                            <div class="customer-detail-item">

                                <i class="bi bi-geo-alt"></i>

                                <div>
                                    <span class="customer-detail-label">
                                        Địa chỉ
                                    </span>

                                    <span class="customer-detail-value">
                                        {{ $invoice->customer_address ?: 'Chưa cập nhật' }}
                                    </span>
                                </div>

                            </div>


                            <div class="customer-detail-item">

                                <i class="bi bi-credit-card"></i>

                                <div>
                                    <span class="customer-detail-label">
                                        Hình thức cọc
                                    </span>

                                    <span class="customer-detail-value">
                                        {{ $paymentMethod }}
                                    </span>
                                </div>

                            </div>


                            <div class="customer-detail-item">

                                <i class="bi bi-person-badge"></i>

                                <div>
                                    <span class="customer-detail-label">
                                        Nhân viên bán hàng
                                    </span>

                                    <span class="customer-detail-value">
                                        {{ $invoice->sale_name ?? (auth()->user()->name ?? 'N/A') }}
                                    </span>
                                </div>

                            </div>

                            <div class="customer-detail-item">

                                <i class="bi bi-shop"></i>

                                <div>
                                    <span class="customer-detail-label">
                                        Showroom
                                    </span>

                                    <span class="customer-detail-value">
                                        {{ $invoice->showroom->name ?? 'Chưa chọn showroom' }}
                                    </span>
                                </div>

                            </div>

                        </div>


                        @if($note)

                            <div class="invoice-note-box">

                                <div class="invoice-note-title">
                                    <i class="bi bi-chat-left-text"></i>
                                    Ghi chú hóa đơn
                                </div>

                                <div class="invoice-note-content">
                                    {!! nl2br(e($note)) !!}
                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- PRODUCTS --}}
                <div class="invoice-content-card">

                    <div class="invoice-card-header">

                        <h2 class="invoice-card-title">
                            <i class="bi bi-box-seam"></i>
                            Danh sách sản phẩm
                        </h2>

                        <span class="badge rounded-pill text-bg-light">
                            {{ $invoice->items->count() }} sản phẩm
                        </span>

                    </div>


                    <div class="invoice-product-wrapper">

                        <table class="modern-product-table">

                            <thead>

                                <tr>

                                    <th style="width: 65px;">
                                        STT
                                    </th>

                                    <th>
                                        Sản phẩm
                                    </th>

                                    <th class="text-center" style="width: 100px;">
                                        Số lượng
                                    </th>

                                    <th class="text-end" style="width: 150px;">
                                        Đơn giá
                                    </th>

                                    <th class="text-end" style="width: 170px;">
                                        Thành tiền
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($invoice->items as $index => $item)

                                    @php

                                        $unitPrice = (float) (
                                            $item->unit_price ?? 0
                                        );

                                        $qty = (float) (
                                            $item->quantity ?? 1
                                        );

                                        $lineTotal = (float) (
                                            $item->subtotal
                                            ?? $item->total
                                            ?? ($unitPrice * $qty)
                                        );

                                    @endphp

                                    <tr>

                                        <td>

                                            <span class="product-number">
                                                {{ $index + 1 }}
                                            </span>

                                        </td>


                                        <td>

                                            <div class="product-name">
                                                {{ $item->product_name }}
                                            </div>

                                        </td>


                                        <td class="text-center">

                                            <span class="product-quantity">

                                                {{
                                                    rtrim(
                                                        rtrim(
                                                            number_format(
                                                                $qty,
                                                                2,
                                                                '.',
                                                                ''
                                                            ),
                                                            '0'
                                                        ),
                                                        '.'
                                                    )
                                                }}

                                            </span>

                                        </td>


                                        <td class="text-end">

                                            <span class="product-price">

                                                {{
                                                    number_format(
                                                        $unitPrice,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}

                                                ₫

                                            </span>

                                        </td>


                                        <td class="text-end">

                                            <span class="product-total">

                                                {{
                                                    number_format(
                                                        $lineTotal,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}

                                                ₫

                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-center py-5 text-muted"
                                        >
                                            <i
                                                class="bi bi-box-seam fs-2 d-block mb-2"
                                            ></i>

                                            Chưa có sản phẩm

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 RIGHT - PAYMENT
            ================================================== --}}

            <div>

                <div class="invoice-content-card payment-card">

                    <div class="invoice-card-header">

                        <h2 class="invoice-card-title">
                            <i class="bi bi-calculator"></i>
                            Thanh toán
                        </h2>

                    </div>


                    <div class="payment-card-body">

                        {{-- STATUS --}}
                        <div class="payment-status">

                            <span class="payment-status-label">
                                Trạng thái
                            </span>

                            @if($remaining <= 0)

                                <span class="payment-status-value">
                                    <span class="payment-status-dot"></span>
                                    Đã thanh toán đủ
                                </span>

                            @else

                                <span
                                    class="payment-status-value"
                                    style="color:#ea580c;"
                                >
                                    <span
                                        class="payment-status-dot"
                                        style="background:#f59e0b;"
                                    ></span>

                                    Còn công nợ

                                </span>

                            @endif

                        </div>


                        {{-- SUBTOTAL --}}
                        <div class="payment-row">

                            <span class="payment-row-label">
                                Tổng tiền hàng
                            </span>

                            <span class="payment-row-value">
                                {{ number_format($subtotal, 0, ',', '.') }} ₫
                            </span>

                        </div>


                        {{-- DISCOUNT --}}
                        <div class="payment-row discount">

                            <span class="payment-row-label">
                                Chiết khấu
                            </span>

                            <span class="payment-row-value">
                                - {{ number_format($discount, 0, ',', '.') }} ₫
                            </span>

                        </div>


                        {{-- FEE --}}
                        <div class="payment-row fee">

                            <span class="payment-row-label">
                                Phí khác
                            </span>

                            <span class="payment-row-value">
                                + {{ number_format($otherFee, 0, ',', '.') }} ₫
                            </span>

                        </div>


                        <hr class="payment-divider">


                        {{-- GRAND TOTAL --}}
                        <div class="payment-grand-total">

                            <div class="payment-grand-label">
                                Tổng thanh toán
                            </div>

                            <div class="payment-grand-value">
                                {{ number_format($grandTotal, 0, ',', '.') }} ₫
                            </div>

                        </div>


                        {{-- DEPOSIT --}}
                        <div class="payment-row">

                            <span class="payment-row-label">
                                Đã đặt cọc
                            </span>

                            <span class="payment-row-value payment-deposit">

                                {{ number_format($deposit, 0, ',', '.') }}
                                ₫

                            </span>

                        </div>


                        {{-- REMAINING --}}
                        <div class="payment-remaining">

                            <div class="payment-remaining-label">

                                @if($remaining > 0)
                                    Còn lại phải thu
                                @else
                                    Đã thanh toán
                                @endif

                            </div>


                            <div class="payment-remaining-value">

                                @if($remaining > 0)

                                    {{ number_format($remaining, 0, ',', '.') }}
                                    ₫

                                @else

                                    0 ₫

                                @endif

                            </div>

                        </div>


                        {{-- PRINT BUTTON --}}
                        <a
                            href="{{ route('invoices.print', $invoice) }}"
                            target="_blank"
                            class="btn-modern btn-invoice-print w-100 justify-content-center mt-3"
                        >

                            <i class="bi bi-printer"></i>

                            In hóa đơn

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             A4 PREVIEW
        ====================================================== --}}

        <div class="invoice-preview-section">

            <div class="invoice-preview-header no-print">

                <div>

                    <h2 class="invoice-preview-title">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Bản xem trước hóa đơn
                    </h2>

                </div>
            </div>


            <div class="invoice-preview-card">

                <div class="invoice-paper">

                    {{-- =================================================
                         HEADER HÓA ĐƠN IN
                    ================================================== --}}

                    <div class="inv-header">

                        <div class="inv-header-left">

                            <img
                                src="{{ route('drive.image', ['id' => '16WjkiyytGbGWOAZ7B5fDH2PHLe3OS2Qw']) }}"
                                alt="Chilux Logo"
                                class="logo"
                            >


                            <div class="inv-region-title">
                                🏢 Miền Nam:
                            </div>

                            <div>
                                - 19 Đinh Thị Thi, Khu đô thị Vạn Phúc,
                                Thủ Đức, TP.HCM
                            </div>

                            <div>
                                - Lầu 2, 208 đường Cô Bắc, phường Cô Giang,
                                Quận 1, TP. HCM
                            </div>

                            <div>
                                - Số 685 Đại lộ Bình Dương, Hiệp Thành,
                                Thủ Dầu Một, Bình Dương
                            </div>


                            <div
                                class="inv-region-title"
                                style="margin-top:4px;"
                            >
                                🏢 Miền Bắc:
                            </div>

                            <div>
                                - 502 Xã Đàn, phường Nam Đồng,
                                Quận Đống Đa, Hà Nội
                            </div>


                            <div class="inv-hotline">
                                ☎ Tổng đài CSKH: 1900 8668 92
                            </div>

                        </div>


                        <div class="inv-header-right">

                            <div class="inv-title">
                                HÓA ĐƠN BÁN HÀNG
                            </div>


                            <div class="inv-date">

                                Ngày
                                {{
                                    $invoice->created_at
                                        ? $invoice->created_at->format('d')
                                        : date('d')
                                }}

                                Tháng
                                {{
                                    $invoice->created_at
                                        ? $invoice->created_at->format('m')
                                        : date('m')
                                }}

                                Năm
                                {{
                                    $invoice->created_at
                                        ? $invoice->created_at->format('Y')
                                        : date('Y')
                                }}

                            </div>


                            <div class="inv-number">

                                Số:
                                {{ $invoice->invoice_code }}

                            </div>


                            <div class="inv-showroom">
                            
                                {{ $invoice->showroom->name ?? 'Chưa chọn showroom' }}
                            </div>

                        </div>


                        <div class="inv-clear"></div>

                    </div>


                    {{-- =================================================
                         CUSTOMER PRINT
                    ================================================== --}}

                    <div class="inv-customer-info">

                        <div class="inv-customer-row">

                            <div class="inv-customer-label">
                                Tên Khách Hàng:
                            </div>

                            <div class="inv-customer-value">

                                {{ $invoice->customer_name
                                    ?: '................................................' }}

                            </div>

                        </div>


                        <div class="inv-customer-row">

                            <div class="inv-customer-label">
                                Số Điện Thoại:
                            </div>

                            <div class="inv-customer-value">

                                {{ $invoice->customer_phone
                                    ?: '................................................' }}

                            </div>

                        </div>


                        <div class="inv-customer-row">

                            <div class="inv-customer-label">
                                Địa Chỉ:
                            </div>

                            <div class="inv-customer-value">

                                {{ $invoice->customer_address
                                    ?: '................................................' }}

                            </div>

                        </div>


                        <div class="inv-customer-row">

                            <div class="inv-customer-label">
                                Hình Thức Cọc:
                            </div>

                            <div class="inv-customer-value">
                                {{ $paymentMethod }}
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         PRODUCT PRINT
                    ================================================== --}}

                    <table class="inv-product-table">

                        <colgroup>

                            <col class="inv-col-stt">

                            <col class="inv-col-product">

                            <col class="inv-col-quantity">

                            <col class="inv-col-price">

                            <col class="inv-col-total">

                        </colgroup>


                        <thead>

                            <tr>

                                <th>STT</th>

                                <th>Tên Sản Phẩm</th>

                                <th>Số Lượng</th>

                                <th>Đơn Giá</th>

                                <th>Thành Tiền</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($invoice->items as $index => $item)

                                @php

                                    $unitPrice = (float) (
                                        $item->unit_price ?? 0
                                    );

                                    $qty = (float) (
                                        $item->quantity ?? 1
                                    );

                                    $lineTotal = (float) (
                                        $item->subtotal
                                        ?? $item->total
                                        ?? ($unitPrice * $qty)
                                    );

                                @endphp


                                <tr>

                                    <td class="inv-center">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="inv-product-name">
                                        {{ $item->product_name }}
                                    </td>

                                    <td class="inv-center">

                                        {{
                                            rtrim(
                                                rtrim(
                                                    number_format(
                                                        $qty,
                                                        2,
                                                        '.',
                                                        ''
                                                    ),
                                                    '0'
                                                ),
                                                '.'
                                            )
                                        }}

                                    </td>

                                    <td class="inv-right">

                                        {{
                                            number_format(
                                                $unitPrice,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}

                                        đ

                                    </td>

                                    <td class="inv-right">

                                        {{
                                            number_format(
                                                $lineTotal,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}

                                        đ

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>


                    {{-- =================================================
                         SUMMARY
                    ================================================== --}}

                    @php

                        /*
                         * Hàm đọc số tiền thành chữ
                         */

                        if (!function_exists('convert_number_to_words_vn')) {

                            function convert_number_to_words_vn($number)
                            {
                                $hyphen = ' ';
                                $conjunction = ' ';
                                $separator = ' ';
                                $negative = 'âm ';

                                $dictionary = [
                                    0 => 'không',
                                    1 => 'một',
                                    2 => 'hai',
                                    3 => 'ba',
                                    4 => 'bốn',
                                    5 => 'năm',
                                    6 => 'sáu',
                                    7 => 'bảy',
                                    8 => 'tám',
                                    9 => 'chín',
                                    10 => 'mười',
                                    11 => 'mười một',
                                    12 => 'mười hai',
                                    13 => 'mười ba',
                                    14 => 'mười bốn',
                                    15 => 'mười lăm',
                                    16 => 'mười sáu',
                                    17 => 'mười bảy',
                                    18 => 'mười tám',
                                    19 => 'mười chín',
                                    20 => 'hai mươi',
                                    30 => 'ba mươi',
                                    40 => 'bốn mươi',
                                    50 => 'năm mươi',
                                    60 => 'sáu mươi',
                                    70 => 'bảy mươi',
                                    80 => 'tám mươi',
                                    90 => 'chín mươi',
                                    100 => 'trăm',
                                    1000 => 'ngàn',
                                    1000000 => 'triệu',
                                    1000000000 => 'tỷ',
                                    1000000000000 => 'nghìn tỷ'
                                ];

                                if (!is_numeric($number)) {
                                    return false;
                                }

                                $number = (int) $number;

                                if ($number < 0) {
                                    return $negative
                                        . convert_number_to_words_vn(abs($number));
                                }

                                if ($number < 21) {
                                    return $dictionary[$number];
                                }

                                if ($number < 100) {

                                    $tens = ((int)($number / 10)) * 10;
                                    $units = $number % 10;

                                    $string = $dictionary[$tens];

                                    if ($units) {

                                        $string .= $hyphen
                                            . (
                                                $units == 1
                                                    ? 'mốt'
                                                    : (
                                                        $units == 5
                                                            ? 'lăm'
                                                            : $dictionary[$units]
                                                    )
                                            );
                                    }

                                    return $string;
                                }

                                if ($number < 1000) {

                                    $hundreds = (int)($number / 100);
                                    $remainder = $number % 100;

                                    $string =
                                        $dictionary[$hundreds]
                                        . ' '
                                        . $dictionary[100];

                                    if ($remainder) {

                                        $string .=
                                            $conjunction
                                            . (
                                                $remainder < 10
                                                    ? 'lẻ '
                                                    : ''
                                            )
                                            . convert_number_to_words_vn(
                                                $remainder
                                            );
                                    }

                                    return $string;
                                }

                                $units = [
                                    1000000000000 => 'nghìn tỷ',
                                    1000000000 => 'tỷ',
                                    1000000 => 'triệu',
                                    1000 => 'ngàn'
                                ];

                                foreach ($units as $value => $name) {

                                    if ($number >= $value) {

                                        $count = (int)($number / $value);
                                        $remainder = $number % $value;

                                        $string =
                                            convert_number_to_words_vn($count)
                                            . ' '
                                            . $name;

                                        if ($remainder) {

                                            $string .= ' '
                                                . convert_number_to_words_vn(
                                                    $remainder
                                                );
                                        }

                                        return $string;
                                    }
                                }

                                return '';
                            }
                        }

                        $amountInWords =
                            convert_number_to_words_vn($remaining);

                    @endphp


                    <div class="inv-summary-wrapper">

                        <div class="inv-summary-note">

                            @if($note)

                                <div style="line-height:1.5;">

                                    <strong>
                                        Ghi Chú Giao Hàng:
                                    </strong>

                                    {!! nl2br(e($note)) !!}

                                </div>

                            @endif


                            <div class="inv-amount-word">

                                SỐ TIỀN BẰNG CHỮ:

                                {{
                                    $amountInWords
                                        ? mb_strtoupper(
                                            $amountInWords,
                                            'UTF-8'
                                        ) . ' ĐỒNG'
                                        : '................................................'
                                }}

                            </div>

                        </div>


                        <div class="inv-summary-box">

                            <div class="inv-summary-row">

                                <div class="inv-summary-label">
                                    TỔNG:
                                </div>

                                <div class="inv-summary-value">

                                    {{
                                        number_format(
                                            $subtotal,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                    đ

                                </div>

                            </div>


                            <div class="inv-summary-row">

                                <div class="inv-summary-label">
                                    CHIẾT KHẤU:
                                </div>

                                <div class="inv-summary-value">

                                    {{
                                        number_format(
                                            $discount,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                    đ

                                </div>

                            </div>


                            <div class="inv-summary-row">

                                <div class="inv-summary-label">
                                    CỌC:
                                </div>

                                <div class="inv-summary-value">

                                    {{
                                        number_format(
                                            $deposit,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                    đ

                                </div>

                            </div>


                            <div class="inv-summary-row">

                                <div class="inv-summary-label">
                                    PHÍ KHÁC:
                                </div>

                                <div class="inv-summary-value">

                                    {{
                                        number_format(
                                            $otherFee,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                    đ

                                </div>

                            </div>


                            <div class="inv-summary-row">

                                <div class="inv-summary-label">
                                    CÒN LẠI:
                                </div>

                                <div class="inv-summary-value">

                                    {{
                                        number_format(
                                            $remaining,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                    đ

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SIGNATURE
                    ================================================== --}}

                    <div class="inv-signature">

                        <div class="inv-signature-column">

                            <div class="inv-signature-title">
                                Khách Hàng
                            </div>

                            <div class="inv-signature-note">
                                (Ký, ghi rõ họ tên)
                            </div>

                            <div class="inv-signature-space"></div>

                            <div>&nbsp;</div>

                        </div>


                        <div class="inv-signature-column">

                            <div class="inv-signature-title">
                                Nhân viên Bán Hàng
                            </div>

                            <div class="inv-signature-note">
                                (Ký, ghi rõ họ tên)
                            </div>

                            <div class="inv-signature-space"></div>

                            <div class="inv-sale-name">

                                {{
                                    $invoice->sale_name
                                    ?? (auth()->user()->name ?? 'N/A')
                                }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection