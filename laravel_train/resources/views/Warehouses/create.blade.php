@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('warehouses.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-building text-primary"></i>
                        Thêm Kho hàng mới
                    </h1>
                    <p class="text-muted">Tạo kho hàng mới trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Có lỗi xảy ra:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card fade-in">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-box-seam me-2"></i>
                        Thông tin kho hàng
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('warehouses.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-tag me-1"></i>
                                    Tên kho
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Nhập tên kho"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Ví dụ: Kho Hàng Hà Nội
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-md-12 mb-3">
                                <label for="location" class="form-label">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    Địa điểm
                                </label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}" 
                                       placeholder="Nhập địa điểm kho"
                                       required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Ví dụ: 123 Đường ABC, Quận 1, TP.HCM
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Tạo kho hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Mẹo quản lý kho
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Đặt tên kho rõ ràng, dễ nhận diện
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Địa điểm phải chi tiết để thuận tiện quản lý
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Có thể phân loại theo khu vực hoặc loại hàng hóa
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('warehouses.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-building me-2"></i>
                            Xem danh sách kho hàng
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="bi bi-question-circle me-2"></i>
                            Trợ giúp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
