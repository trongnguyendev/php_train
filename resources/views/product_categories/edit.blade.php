@extends('layouts.app')

@section('content')
@can('update', $productCategory)
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-pencil text-warning"></i> Chỉnh sửa Loại Showroom</h1>

    <form action="{{ route('product_categories.update', $productCategory) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên loại showroom</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $productCategory->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning">Cập nhật</button>
        <a href="{{ route('product_categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endcan
@cannot('update', $productCategory)
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
                    Tài khoản của bạn không có quyền chỉnh sửa Danh Mục Sản Phẩm.
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
