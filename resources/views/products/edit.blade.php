@extends('layouts.app')

@section('content')

<style>

    .product-form-page {
        min-height: calc(100vh - 70px);
        background: #f6f8fb;
        padding: 35px 0 60px;
    }

    /* =========================
       MAIN CARD
    ========================= */

    .form-card {
        max-width: 850px;
        margin: 0 auto;

        background: #fff;

        border: 1px solid #edf0f5;

        border-radius: 18px;

        overflow: hidden;

        box-shadow:
            0 8px 30px rgba(20, 30, 50, .06);
    }


    /* =========================
       HEADER
    ========================= */

    .form-header {
        padding: 25px 30px;

        border-bottom: 1px solid #edf0f5;

        background: #fff;
    }

    .header-icon {
        width: 48px;
        height: 48px;

        border-radius: 13px;

        display: flex;

        align-items: center;

        justify-content: center;

        background: #eef4ff;

        color: #0d6efd;

        font-size: 22px;

        flex-shrink: 0;
    }

    .form-title {
        font-size: 20px;

        font-weight: 700;

        color: #172033;

        margin-bottom: 4px;
    }

    .form-subtitle {
        color: #8a94a6;

        font-size: 13px;
    }


    /* =========================
       BODY
    ========================= */

    .form-body {
        padding: 30px;
    }


    /* =========================
       FORM GROUP
    ========================= */

    .form-group {
        margin-bottom: 25px;
    }

    .form-label-custom {
        display: flex;

        align-items: center;

        gap: 7px;

        margin-bottom: 9px;

        color: #344054;

        font-size: 14px;

        font-weight: 600;
    }

    .required {
        color: #f04438;
    }

    .form-control-custom {
        width: 100%;

        height: 48px;

        border: 1px solid #d0d5dd;

        border-radius: 10px;

        padding: 0 14px;

        font-size: 14px;

        color: #101828;

        transition: all .2s ease;
    }

    .form-control-custom:focus {

        border-color: #86b7fe;

        box-shadow:
            0 0 0 4px rgba(13, 110, 253, .10);
    }


    /* =========================
       PRICE
    ========================= */

    .price-wrapper {
        position: relative;
    }

    .price-input {
        padding-right: 65px;

        font-size: 17px;

        font-weight: 600;
    }

    .price-unit {

        position: absolute;

        right: 14px;

        top: 50%;

        transform: translateY(-50%);

        color: #667085;

        font-size: 13px;

        font-weight: 600;

        pointer-events: none;
    }


    /* =========================
       HELP TEXT
    ========================= */

    .form-help {
        margin-top: 7px;

        color: #98a2b3;

        font-size: 12px;
    }


    /* =========================
       ERROR
    ========================= */

    .form-control-custom.is-invalid {

        border-color: #f04438;

        box-shadow:
            0 0 0 3px rgba(240, 68, 56, .08);
    }

    .invalid-feedback-custom {

        display: block;

        margin-top: 7px;

        color: #d92d20;

        font-size: 12px;
    }


    /* =========================
       INFO BOX
    ========================= */

    .info-box {

        display: flex;

        align-items: flex-start;

        gap: 12px;

        padding: 15px;

        margin-top: 5px;

        background: #f8faff;

        border: 1px solid #e7efff;

        border-radius: 11px;
    }

    .info-icon {

        width: 30px;

        height: 30px;

        border-radius: 8px;

        display: flex;

        align-items: center;

        justify-content: center;

        background: #eaf2ff;

        color: #2f6fed;

        flex-shrink: 0;

        font-size: 14px;
    }

    .info-text {

        color: #667085;

        font-size: 12px;

        line-height: 1.6;
    }


    /* =========================
       FOOTER
    ========================= */

    .form-footer {

        padding: 20px 30px;

        border-top: 1px solid #edf0f5;

        background: #fcfcfd;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;
    }

    .btn-cancel {

        height: 42px;

        padding: 0 18px;

        border-radius: 9px;

        border: 1px solid #d0d5dd;

        background: #fff;

        color: #344054;

        font-size: 13px;

        font-weight: 600;

        text-decoration: none;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        transition: all .2s ease;
    }

    .btn-cancel:hover {

        background: #f9fafb;

        color: #101828;
    }

    .btn-save {

        height: 42px;

        padding: 0 20px;

        border: 0;

        border-radius: 9px;

        background: #0d6efd;

        color: #fff;

        font-size: 13px;

        font-weight: 600;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 7px;

        box-shadow:
            0 4px 10px rgba(13, 110, 253, .18);

        transition: all .2s ease;

        cursor: pointer;
    }

    .btn-save:hover {

        background: #0b5ed7;

        transform: translateY(-1px);

        box-shadow:
            0 6px 15px rgba(13, 110, 253, .25);
    }


    /* =========================
       BREADCRUMB
    ========================= */

    .breadcrumb-custom {

        max-width: 850px;

        margin: 0 auto 15px;

        padding: 0 3px;

        display: flex;

        align-items: center;

        gap: 8px;

        font-size: 13px;

        color: #98a2b3;
    }

    .breadcrumb-custom a {

        color: #667085;

        text-decoration: none;

        font-weight: 500;
    }

    .breadcrumb-custom a:hover {

        color: #0d6efd;
    }


    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 768px) {

        .product-form-page {

            padding: 20px 12px 40px;

        }

        .form-header {

            padding: 20px;

        }

        .form-body {

            padding: 20px;

        }

        .form-footer {

            padding: 16px 20px;

        }

        .header-icon {

            width: 42px;

            height: 42px;

            font-size: 19px;

        }

        .form-title {

            font-size: 18px;

        }

        .form-footer {

            flex-direction: column-reverse;

            align-items: stretch;

        }

        .btn-cancel,
        .btn-save {

            width: 100%;

        }

    }

</style>


<div class="product-form-page">

    <div class="container">


        {{-- =========================
             BREADCRUMB
        ========================== --}}

        <div class="breadcrumb-custom">

            <a href="{{ route('products.index') }}">
                Sản phẩm
            </a>

            <span>
                /
            </span>

            <span>

                {{ $product->exists
                    ? 'Cập nhật'
                    : 'Thêm mới'
                }}

            </span>

        </div>


        {{-- =========================
             CARD
        ========================== --}}

        <div class="form-card">


            {{-- HEADER --}}

            <div class="form-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="header-icon">

                        @if($product->exists)

                            ✎

                        @else

                            +

                        @endif

                    </div>


                    <div>

                        <div class="form-title">

                            {{ $product->exists
                                ? 'Cập nhật sản phẩm'
                                : 'Thêm sản phẩm mới'
                            }}

                        </div>

                        <div class="form-subtitle">

                            {{ $product->exists
                                ? 'Chỉnh sửa thông tin và giá bán của sản phẩm'
                                : 'Nhập thông tin để thêm sản phẩm vào hệ thống'
                            }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORM --}}

            <form
                method="POST"
                id="productForm"
                action="{{
                    $product->exists
                        ? route('products.update', $product)
                        : route('products.store')
                }}"
            >

                @csrf

                @if($product->exists)

                    @method('PUT')

                @endif


                {{-- BODY --}}

                <div class="form-body">


                    {{-- =========================
                         NAME
                    ========================== --}}

                    <div class="form-group">

                        <label class="form-label-custom">

                            <span>
                                🏷️
                            </span>

                            Tên sản phẩm

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="name"
                            class="form-control form-control-custom
                                {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ old('name', $product->name) }}"
                            placeholder="Ví dụ: Máy lọc nước ENIC"
                            required
                            autofocus
                        >


                        @error('name')

                            <div class="invalid-feedback-custom">

                                {{ $message }}

                            </div>

                        @else

                            <div class="form-help">

                                Nhập tên sản phẩm dễ nhận biết và phân biệt.

                            </div>

                        @enderror

                    </div>



                    {{-- =========================
                         PRICE
                    ========================== --}}

                    <div class="form-group">

                        <label class="form-label-custom">

                            <span>
                                💰
                            </span>

                            Giá bán

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="price-wrapper">

                            {{-- QUAN TRỌNG:
                                 type="text" để hiển thị 3.800.000
                            --}}

                            <input
                                type="text"
                                id="priceInput"
                                name="price"
                                class="form-control form-control-custom price-input
                                    {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                value="{{ old('price', $product->price ?? 0) }}"
                                placeholder="Ví dụ: 3.800.000"
                                inputmode="numeric"
                                autocomplete="off"
                                required
                            >

                            <span class="price-unit">
                                VNĐ
                            </span>

                        </div>


                        <div class="form-help">

                            Nhập số tiền, hệ thống tự động thêm dấu chấm.
                            Ví dụ: <strong>3800000</strong>
                            → <strong>3.800.000</strong>

                        </div>


                        @error('price')

                            <div class="invalid-feedback-custom">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>



                    {{-- =========================
                         INFO
                    ========================== --}}

                    <div class="info-box">

                        <div class="info-icon">
                            ℹ
                        </div>

                        <div class="info-text">

                            <strong>
                                Lưu ý:
                            </strong>

                            Giá sản phẩm được sử dụng khi tạo hóa đơn.
                            Nếu bạn thay đổi giá, các hóa đơn đã tạo trước đó
                            vẫn giữ nguyên giá cũ.

                        </div>

                    </div>


                </div>


                {{-- =========================
                     FOOTER
                ========================== --}}

                <div class="form-footer">


                    {{-- CANCEL --}}

                    <a
                        href="{{ route('products.index') }}"
                        class="btn-cancel"
                    >

                        ←

                        <span class="ms-2">
                            Quay lại danh sách
                        </span>

                    </a>


                    {{-- SAVE --}}

                    <button
                        type="submit"
                        class="btn-save"
                        id="btnSave"
                    >

                        <span>
                            ✓
                        </span>

                        {{ $product->exists
                            ? 'Lưu thay đổi'
                            : 'Tạo sản phẩm'
                        }}

                    </button>


                </div>


            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const priceInput = document.getElementById('priceInput');

    const productForm = document.getElementById('productForm');

    const btnSave = document.getElementById('btnSave');


    if (!priceInput || !productForm) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | HÀM FORMAT TIỀN
    |--------------------------------------------------------------------------
    |
    | 3800000
    |       ↓
    | 3.800.000
    |
    */

    function formatMoney(value) {

        // Chỉ giữ lại số
        let number = value.replace(/\D/g, '');


        // Nếu không có số
        if (number === '') {
            return '';
        }


        // Xóa số 0 ở đầu
        number = number.replace(/^0+(?=\d)/, '');


        // Thêm dấu chấm mỗi 3 số
        return number.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            '.'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | FORMAT GIÁ KHI MỞ TRANG
    |--------------------------------------------------------------------------
    |
    | Ví dụ DB:
    |
    | 3800000
    |
    | Hiển thị:
    |
    | 3.800.000
    |
    */

    if (priceInput.value) {

        priceInput.value =
            formatMoney(priceInput.value);

    }



    /*
    |--------------------------------------------------------------------------
    | FORMAT KHI GÕ
    |--------------------------------------------------------------------------
    */

    priceInput.addEventListener('input', function () {

        // Lấy giá trị hiện tại
        let value = this.value;


        // Format
        this.value = formatMoney(value);

    });



    /*
    |--------------------------------------------------------------------------
    | CHẶN KÝ TỰ KHÔNG PHẢI SỐ
    |--------------------------------------------------------------------------
    */

    priceInput.addEventListener('keydown', function (event) {

        const allowedKeys = [
            'Backspace',
            'Delete',
            'ArrowLeft',
            'ArrowRight',
            'ArrowUp',
            'ArrowDown',
            'Tab',
            'Home',
            'End'
        ];


        // Cho phép Ctrl + A / C / V / X
        if (
            event.ctrlKey ||
            event.metaKey
        ) {
            return;
        }


        // Cho phép các phím điều hướng
        if (
            allowedKeys.includes(event.key)
        ) {
            return;
        }


        // Chỉ cho phép số
        if (!/^[0-9]$/.test(event.key)) {

            event.preventDefault();

        }

    });



    /*
    |--------------------------------------------------------------------------
    | KHI SUBMIT
    |--------------------------------------------------------------------------
    |
    | 3.800.000
    |       ↓
    | 3800000
    |
    | Laravel sẽ nhận:
    |
    | price = 3800000
    |
    */

    productForm.addEventListener('submit', function () {

        priceInput.value =
            priceInput.value
                .replace(/\./g, '')
                .replace(/,/g, '');


        /*
        | Chống click nút lưu nhiều lần
        */

        if (btnSave) {

            btnSave.disabled = true;

            btnSave.innerHTML =
                '<span>⏳</span> Đang lưu...';

        }

    });

});

</script>

@endsection