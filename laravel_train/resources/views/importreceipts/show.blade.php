@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết phiếu nhập</h1>

    <div class="mb-3">
        <strong>Mã phiếu:</strong> {{ $importreceipt->code }}
    </div>

    <div class="mb-3">
        <strong>Kho:</strong> {{ $importreceipt->warehouse->name }}
    </div>

    <div class="mb-3">
        <strong>Ngày nhập:</strong> {{ $importreceipt->received_at }}
    </div>

    <div class="mb-3">
        <strong>Sản phẩm:</strong>
        <ul>
            @foreach($importreceipt->products as $product)
                <li>{{ $product->name }} - SL: {{ $product->pivot->quantity }}</li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('importreceipts.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
