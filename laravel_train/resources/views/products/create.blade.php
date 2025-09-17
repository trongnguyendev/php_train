@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-box-seam text-primary"></i>
                        Thêm Sản Phẩm Mới
                    </h1>
                    <p class="text-muted">Nhập thông tin chi tiết để tạo sản phẩm</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiển thị lỗi -->
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
            <!-- Form -->
            <div class="card fade-in">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin sản phẩm
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Tên sản phẩm -->
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-tag me-1"></i>
                                    Tên sản phẩm
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Nhập tên sản phẩm" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mã sản phẩm -->
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">
                                    <i class="bi bi-upc-scan me-1"></i>
                                    Mã sản phẩm
                                </label>
                                <input type="text" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" 
                                       value="{{ old('code') }}" 
                                       placeholder="VD: SP1001" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giá -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">
                                    <i class="bi bi-currency-dollar me-1"></i>
                                    Giá
                                </label>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" 
                                       value="{{ old('price') }}" 
                                       placeholder="Nhập giá" 
                                       min="0" step="0.01" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mô tả -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">
                                    <i class="bi bi-card-text me-1"></i>
                                    Mô tả
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Lưu sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Gợi ý -->
        <div class="col-lg-4">
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Gợi ý nhập sản phẩm
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Tên ngắn gọn, dễ nhớ</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Mã sản phẩm duy nhất</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Giá hợp lý</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Mô tả chi tiết để dễ bán</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
