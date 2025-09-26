@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3">
                <i class="bi bi-geo-alt text-info"></i> Chi tiết Tỉnh
            </h1>
            <a href="{{ route('province.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $province->id }}</p>
            <p><strong>Tên Tỉnh/Thành phố:</strong> {{ $province->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $province->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $province->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>
@endsection
