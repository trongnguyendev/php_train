@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-pencil-fill text-warning"></i>
                        Chỉnh sửa kho hàng
                    </h1>
                    <p class="text-muted">Cập nhật thông tin kho: {{ $warehouse->name }}</p>
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
                    <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Thông tin cơ bản
                                </h6>
                            </div>
                            <div class="card-body">
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
                                               value="{{ old('name', $warehouse->name) }}" 
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
                                               value="{{ old('location', $warehouse->location) }}" 
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
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>
                                Cập nhật kho
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Current Warehouse Info -->
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin hiện tại
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">ID:</span>
                                <span class="badge bg-secondary">{{ $warehouse->id }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Ngày tạo:</span>
                                <span class="fw-bold">{{ $warehouse->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Cập nhật lần cuối:</span>
                                <span class="fw-bold">{{ $warehouse->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Lưu ý khi chỉnh sửa
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Tên kho nên ngắn gọn và dễ nhận biết
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Địa chỉ nên đầy đủ để thuận tiện quản lý
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Thay đổi sẽ được áp dụng ngay lập tức
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('warehouses.show', $warehouse) }}" 
                           class="btn btn-outline-primary">
                            <i class="bi bi-eye me-2"></i>
                            Xem thông tin
                        </a>
                        <a href="{{ route('warehouses.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="bi bi-building me-2"></i>
                            Danh sách kho hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
