@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo phiếu nhập</h1>

    <form action="{{ route('importreceipts.store') }}" method="POST">
        @csrf

        {{-- Chọn kho --}}
        <div class="mb-3">
            <label>Kho hàng</label>
            <select name="warehouse_id" class="form-control">
                <option value="">-- Chọn kho --</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Mã phiếu --}}
        <div class="mb-3">
            <label>Mã phiếu</label>
            <input type="text" name="code" class="form-control">
        </div>

        {{-- Ngày nhập --}}
        <div class="mb-3">
            <label>Ngày nhập</label>
            <input type="date" name="received_at" class="form-control">
        </div>

        {{-- Chọn sản phẩm --}}
        <div id="products-wrapper">
            <label>Sản phẩm</label>
            <div class="d-flex mb-2 product-row">
                <select name="products[0][id]" class="form-control me-2">
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="products[0][quantity]" class="form-control" placeholder="Số lượng" min="1">
                <button type="button" class="btn btn-danger ms-2 remove-row">X</button>
            </div>
        </div>

        <button type="button" id="add-row" class="btn btn-secondary mb-3">+ Thêm sản phẩm</button>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

{{-- Script thêm/xóa dòng sản phẩm --}}
<script>
    let rowIndex = 1;
    document.getElementById('add-row').addEventListener('click', function () {
        let wrapper = document.getElementById('products-wrapper');
        let newRow = document.createElement('div');
        newRow.classList.add('d-flex', 'mb-2', 'product-row');
        newRow.innerHTML = `
            <select name="products[${rowIndex}][id]" class="form-control me-2">
                <option value="">-- Chọn sản phẩm --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <input type="number" name="products[${rowIndex}][quantity]" class="form-control" placeholder="Số lượng" min="1">
            <button type="button" class="btn btn-danger ms-2 remove-row">X</button>
        `;
        wrapper.appendChild(newRow);

        newRow.querySelector('.remove-row').addEventListener('click', function () {
            newRow.remove();
        });

        rowIndex++;
    });

    document.querySelectorAll('.remove-row').forEach(btn => {
        btn.addEventListener('click', function () {
            this.closest('.product-row').remove();
        });
    });
</script>
@endsection
