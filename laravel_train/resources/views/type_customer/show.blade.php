@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-people text-info"></i> Chi tiết Loại Khách hàng</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $typeCustomer->id }}</p>
            <p><strong>Tên loại khách hàng:</strong> {{ $typeCustomer->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $typeCustomer->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $typeCustomer->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('type_customer.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
