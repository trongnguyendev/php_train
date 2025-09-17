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
                        Kho hàng
                    </h1>
                    <p class="text-muted">Thêm / chỉnh sửa thông tin kho hàng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Warehouse -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card fade-in">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Thông tin kho
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($warehouse) ? route('warehouses.update', $warehouse) : route('warehouses.store') }}" method="POST">
                        @csrf
                        @if(isset($warehouse))
                            @method('PUT')
                        @endif

                        <!-- Tên kho -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên kho</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $warehouse->name ?? '') }}" 
                                   placeholder="Nhập tên kho">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vị trí kho -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Vị trí</label>
                            <input type="text" 
                                   class="form-control @error('location') is-invalid @enderror" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location', $warehouse->location ?? '') }}" 
                                   placeholder="Nhập vị trí kho">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                {{ isset($warehouse) ? 'Cập nhật' : 'Lưu' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
