@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-pencil-fill text-warning"></i>
                        Chỉnh sửa Sản phẩm
                    </h1>
                    <p class="text-muted">Cập nhật thông tin sản phẩm: {{ $product->name }}</p>
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
                        Thông tin sản phẩm
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Product Info Section -->
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
                                            Tên sản phẩm
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $product->name) }}" 
                                               placeholder="Nhập tên sản phẩm"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Code -->
                                    <div class="col-md-12 mb-3">
                                        <label for="code" class="form-label">
                                            <i class="bi bi-upc-scan me-1"></i>
                                            Mã sản phẩm
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('code') is-invalid @enderror" 
                                               id="code" 
                                               name="code" 
                                               value="{{ old('code', $product->code) }}" 
                                               placeholder="Nhập mã sản phẩm"
                                               required>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-12 mb-3">
                                        <label for="price" class="form-label">
                                            <i class="bi bi-cash me-1"></i>
                                            Giá sản phẩm
                                        </label>
                                        <input type="number" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price', $product->price) }}" 
                                               placeholder="Nhập giá sản phẩm"
                                               required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-card-text me-1"></i>
                                            Mô tả sản phẩm
                                        </label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="4" 
                                                  placeholder="Nhập mô tả sản phẩm">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>
                                Cập nhật sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin hiện tại
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"><strong>ID:</strong> {{ $product->id }}</div>
                    <div class="mb-2"><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</div>
                    <div class="mb-2"><strong>Cập nhật lần cuối:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
