@extends('layouts.app')

@section('content')
@can('view', App\Models\Showroom::class)
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-building text-info"></i> Chi tiết Loại Showroom</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $typeShowroom->id }}</p>
            <p><strong>Tên loại showroom:</strong> {{ $typeShowroom->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $typeShowroom->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $typeShowroom->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('type_showroom.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endcan
@cannot('view', App\Models\Showroom::class)
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <!-- Icon -->
                <div class="mb-4">
                    <i class="bi bi-shield-lock text-danger" style="font-size: 5rem; opacity: 0.8;"></i>
                </div>
                
                <!-- Content -->
                <h3 class="fw-bold mb-3">Không có quyền truy cập</h3>
                <p class="text-muted mb-4">
                    Tài khoản của bạn không có quyền xem Chi tiết Loại Showroom.
                </p>
                
                <!-- Action -->
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Quay về trang chủ
                </a>
            </div>
        </div>
    </div>
</div>
@endcannot
@endsection
