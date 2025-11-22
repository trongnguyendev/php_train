@extends('layouts.app')

@section('content')
@can('view', App\Models\SaleUser::class)
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-building text-info"></i> Chi tiết Loại Showroom</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $cutomerStatus->id }}</p>
            <p><strong>Tên loại showroom:</strong> {{ $cutomerStatus->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $cutomerStatus->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $cutomerStatus->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('customer_status.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endcan
@cannot('view', App\Models\SaleUser::class)
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
                    Tài khoản của bạn không có quyền xem Chi tiết Loại Danh mục Sale.
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
