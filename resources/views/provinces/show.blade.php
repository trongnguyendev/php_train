@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-building text-info"></i> Chi tiết Tỉnh</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $provinces->id }}</p>
            <p><strong>Tên loại showroom:</strong> {{ $provinces->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $provinces->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $provinces->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('customer_status.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
