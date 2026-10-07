@extends('layouts.app')

@section('content')

<style>
    .product-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
    }

    .page-title {
        font-weight: 700;
        color: #172033;
        letter-spacing: -0.3px;
    }

    .page-subtitle {
        color: #7b8497;
        font-size: 14px;
    }

    /* =========================
       STAT CARD
    ========================= */

    .stat-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 14px;
        padding: 18px;
        height: 100%;
        transition: all .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(20, 30, 50, .07);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 11px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 19px;

        background: #eef4ff;
        color: #3b73e8;
    }

    .stat-label {
        color: #8992a3;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 23px;
        font-weight: 700;
        color: #172033;
    }


    /* =========================
       PRODUCT CARD
    ========================= */

    .product-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 16px;
        overflow: hidden;
    }

    .product-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #edf0f5;
    }


    /* =========================
       TABLE
    ========================= */

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8f9fc;

        color: #697386;

        font-size: 12px;
        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: .4px;

        padding: 14px 20px;

        border-bottom: 1px solid #edf0f5;

        white-space: nowrap;
    }

    .table tbody td {
        padding: 17px 20px;

        vertical-align: middle;

        border-color: #f0f2f6;
    }

    .table tbody tr {
        transition: background .15s ease;
    }

    .table tbody tr:hover {
        background: #fafbfe;
    }


    /* =========================
       PRODUCT ID
    ========================= */

    .product-id {
        width: 38px;
        height: 34px;

        border-radius: 9px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        background: #f1f4f8;

        color: #667085;

        font-size: 12px;

        font-weight: 700;
    }


    /* =========================
       PRODUCT NAME
    ========================= */

    .product-name {
        font-weight: 600;
        color: #1d2939;

        margin-bottom: 3px;
    }

    .product-code {
        font-size: 12px;
        color: #98a2b3;
    }


    /* =========================
       PRICE
    ========================= */

    .product-price {
        color: #111827;

        font-size: 16px;

        font-weight: 700;
    }


    /* =========================
       STATUS
    ========================= */

    .badge-status {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        border-radius: 999px;

        padding: 6px 11px;

        font-size: 12px;

        font-weight: 600;
    }

    .badge-status.active {
        background: #ecfdf3;
        color: #027a48;
    }

    .badge-status.inactive {
        background: #f2f4f7;
        color: #667085;
    }

    .status-dot {
        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: currentColor;
    }


    /* =========================
       BUTTON
    ========================= */

    .btn-add-product {
        border-radius: 10px;

        padding: 10px 16px;

        font-weight: 600;

        box-shadow:
            0 4px 12px rgba(13, 110, 253, .18);
    }

    .btn-edit {
        border-radius: 8px;

        font-size: 13px;

        font-weight: 600;

        padding: 7px 12px;
    }


    /* =========================
       EMPTY
    ========================= */

    .empty-state {
        padding: 70px 20px;
    }

    .empty-icon {
        width: 64px;
        height: 64px;

        border-radius: 16px;

        background: #f2f4f7;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: 0 auto 15px;

        font-size: 26px;
    }


    /* =========================
       PAGINATION
    ========================= */

    .product-card-footer {
        padding: 16px 20px;

        border-top: 1px solid #edf0f5;

        background: #fff;
    }

    .pagination-wrapper {
        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 15px;

        flex-wrap: wrap;
    }

    .pagination-info {
        color: #667085;

        font-size: 13px;
    }

    .pagination-info strong {
        color: #344054;
    }

    .product-pagination {
        display: flex;

        align-items: center;

        gap: 5px;
    }

    .pagination-btn {
        width: 36px;
        height: 36px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        border-radius: 8px;

        text-decoration: none;

        color: #667085;

        background: #fff;

        border: 1px solid #e4e7ec;

        font-size: 13px;

        font-weight: 600;

        transition: all .2s ease;
    }

    .pagination-btn:hover {
        background: #f2f4f7;

        color: #0d6efd;

        border-color: #cfd8ea;
    }

    .pagination-btn.active {
        background: #0d6efd;

        border-color: #0d6efd;

        color: #fff;

        box-shadow:
            0 3px 8px rgba(13, 110, 253, .20);
    }

    .pagination-btn.disabled {
        opacity: .4;

        pointer-events: none;

        cursor: not-allowed;
    }


    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 768px) {

        .product-page {
            padding: 15px 0;
        }

        .page-header {
            align-items: flex-start !important;

            gap: 15px;
        }

        .page-header .btn-add-product {
            white-space: nowrap;
        }

        .stat-card {
            padding: 14px;
        }

        .table thead th,
        .table tbody td {
            padding: 13px 14px;
        }

        .pagination-wrapper {
            flex-direction: column;

            align-items: center;
        }

    }

</style>


<div class="product-page py-4">

    <div class="container-fluid px-3 px-lg-4">


        {{-- =========================
             HEADER
        ========================== --}}

        <div class="page-header d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="page-title mb-1">
                    Quản lý sản phẩm
                </h3>

                <div class="page-subtitle">
                    Quản lý danh sách sản phẩm và giá bán hiện tại
                </div>

            </div>


            <a
                href="{{ route('products.create') }}"
                class="btn btn-primary btn-add-product"
            >
                + Thêm sản phẩm
            </a>

        </div>


        {{-- =========================
             SUCCESS
        ========================== --}}

        @if(session('success'))

            <div
                class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4"
            >

                <div class="me-2">
                    ✓
                </div>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- =========================
             STATISTICS
        ========================== --}}

        @php

            $totalProducts = $products->total();

            /*
             * Lưu ý:
             * Hai số dưới đây đang tính trên trang hiện tại.
             */
            $activeProducts = $products->getCollection()
                ->where('is_active', true)
                ->count();

            $inactiveProducts = $products->getCollection()
                ->where('is_active', false)
                ->count();

        @endphp


        <div class="row g-3 mb-4">


            {{-- TOTAL --}}

            <div class="col-12 col-md-4">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon">
                            📦
                        </div>

                        <div>

                            <div class="stat-label">
                                Tổng sản phẩm
                            </div>

                            <div class="stat-value">
                                {{ number_format($totalProducts) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ACTIVE --}}

            <div class="col-12 col-md-4">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background:#ecfdf3;color:#039855;"
                        >
                            ✓
                        </div>

                        <div>

                            <div class="stat-label">
                                Đang bán
                            </div>

                            <div class="stat-value">
                                {{ number_format($activeProducts) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- INACTIVE --}}

            <div class="col-12 col-md-4">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="stat-icon"
                            style="background:#f2f4f7;color:#667085;"
                        >
                            —
                        </div>

                        <div>

                            <div class="stat-label">
                                Ngừng bán
                            </div>

                            <div class="stat-value">
                                {{ number_format($inactiveProducts) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             PRODUCT TABLE
        ========================== --}}

        <div class="product-card shadow-sm">


            {{-- TABLE HEADER --}}

            <div class="product-card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="fw-bold">
                            Danh sách sản phẩm
                        </div>

                        <div class="text-muted small mt-1">
                            Các sản phẩm đang được quản lý trong hệ thống
                        </div>

                    </div>


                    @if($products->total() > 0)

                        <div class="text-muted small">

                            {{ $products->firstItem() }}

                            -

                            {{ $products->lastItem() }}

                            /

                            {{ $products->total() }}

                        </div>

                    @endif

                </div>

            </div>


            {{-- TABLE --}}

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="80">
                                ID
                            </th>

                            <th>
                                Sản phẩm
                            </th>

                            <th width="230">
                                Giá hiện tại
                            </th>

                            <th width="170">
                                Trạng thái
                            </th>

                            <th width="140" class="text-end">
                                Thao tác
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @forelse($products as $product)

                            <tr>


                                {{-- ID --}}

                                <td>

                                    <span class="product-id">

                                        #{{ $product->id }}

                                    </span>

                                </td>


                                {{-- NAME --}}

                                <td>

                                    <div class="product-name">

                                        {{ $product->name }}

                                    </div>

                                    <div class="product-code">

                                        Sản phẩm #{{ $product->id }}

                                    </div>

                                </td>


                                {{-- PRICE --}}

                                <td>

                                    <div class="product-price">

                                        {{ number_format($product->price, 0, ',', '.') }}

                                        <span class="fw-normal fs-6">
                                            ₫
                                        </span>

                                    </div>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($product->is_active)

                                        <span class="badge-status active">

                                            <span class="status-dot"></span>

                                            Đang bán

                                        </span>

                                    @else

                                        <span class="badge-status inactive">

                                            <span class="status-dot"></span>

                                            Ngừng bán

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td class="text-end">

                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="btn btn-sm btn-outline-primary btn-edit"
                                    >
                                        ✎ Sửa giá
                                    </a>

                                </td>


                            </tr>

                        @empty


                            <tr>

                                <td colspan="5">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            📦
                                        </div>

                                        <div class="fw-semibold mb-1">
                                            Chưa có sản phẩm
                                        </div>

                                        <div class="text-muted small mb-3">
                                            Hãy thêm sản phẩm đầu tiên vào hệ thống.
                                        </div>

                                        <a
                                            href="{{ route('products.create') }}"
                                            class="btn btn-primary btn-sm"
                                        >
                                            + Thêm sản phẩm
                                        </a>

                                    </div>

                                </td>

                            </tr>


                        @endforelse


                    </tbody>

                </table>

            </div>


            {{-- =========================
                 PAGINATION
            ========================== --}}

            @if($products->hasPages())

                <div class="product-card-footer">

                    <div class="pagination-wrapper">


                        {{-- INFO --}}

                        <div class="pagination-info">

                            Trang

                            <strong>
                                {{ $products->currentPage() }}
                            </strong>

                            /

                            <strong>
                                {{ $products->lastPage() }}
                            </strong>

                            · Tổng

                            <strong>
                                {{ number_format($products->total()) }}
                            </strong>

                            sản phẩm

                        </div>


                        {{-- BUTTONS --}}

                        <div class="product-pagination">


                            {{-- PREVIOUS --}}

                            <a
                                href="{{ $products->previousPageUrl() ?? '#' }}"
                                class="pagination-btn {{ $products->onFirstPage() ? 'disabled' : '' }}"
                                aria-label="Trang trước"
                            >
                                ←
                            </a>


                            {{-- FIRST PAGE --}}

                            @if($products->currentPage() > 3)

                                <a
                                    href="{{ $products->url(1) }}"
                                    class="pagination-btn"
                                >
                                    1
                                </a>

                                @if($products->currentPage() > 4)

                                    <span class="px-1 text-muted">
                                        ...
                                    </span>

                                @endif

                            @endif


                            {{-- PAGE NUMBERS --}}

                            @foreach(
                                $products->getUrlRange(
                                    max(1, $products->currentPage() - 2),
                                    min(
                                        $products->lastPage(),
                                        $products->currentPage() + 2
                                    )
                                ) as $page => $url
                            )

                                <a
                                    href="{{ $url }}"
                                    class="pagination-btn {{ $page == $products->currentPage() ? 'active' : '' }}"
                                >
                                    {{ $page }}
                                </a>

                            @endforeach


                            {{-- LAST PAGE --}}

                            @if($products->currentPage() < $products->lastPage() - 2)

                                @if($products->currentPage() < $products->lastPage() - 3)

                                    <span class="px-1 text-muted">
                                        ...
                                    </span>

                                @endif

                                <a
                                    href="{{ $products->url($products->lastPage()) }}"
                                    class="pagination-btn"
                                >
                                    {{ $products->lastPage() }}
                                </a>

                            @endif


                            {{-- NEXT --}}

                            <a
                                href="{{ $products->nextPageUrl() ?? '#' }}"
                                class="pagination-btn {{ !$products->hasMorePages() ? 'disabled' : '' }}"
                                aria-label="Trang sau"
                            >
                                →
                            </a>


                        </div>

                    </div>

                </div>

            @endif


        </div>

    </div>

</div>

@endsection