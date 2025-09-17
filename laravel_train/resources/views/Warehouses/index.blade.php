@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-building text-primary"></i>
                        Quản lý Kho hàng
                    </h1>
                    <p class="text-muted">Quản lý tất cả kho hàng trong hệ thống một cách dễ dàng</p>
                </div>
                <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i>
                    Thêm Kho hàng mới
                </a>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card text-center">
                <h3>{{ $warehouses->count() }}</h3>
                <p>Tổng số kho hàng</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h3>{{ $warehouses->whereNotNull('location')->count() }}</h3>
                <p>Có địa điểm</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <h3>{{ $warehouses->whereNull('location')->count() }}</h3>
                <p>Chưa có địa điểm</p>
            </div>
        </div>
    </div>

    <!-- Warehouses Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Danh sách Kho hàng
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-box-seam me-1"></i>Tên kho</th>
                            <th><i class="bi bi-geo-alt me-1"></i>Địa điểm</th>
                            <th><i class="bi bi-calendar me-1"></i>Ngày tạo</th>
                            <th><i class="bi bi-gear me-1"></i>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warehouses as $warehouse)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $warehouse->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $warehouse->name }}</div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $warehouse->location ?? 'Chưa có' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $warehouse->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('warehouses.show', $warehouse) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('warehouses.edit', $warehouse) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa"
                                                    onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa kho hàng này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-emoji-frown display-1"></i>
                                        <h4 class="mt-3">Không có kho hàng nào</h4>
                                        <p class="mb-3">Hãy tạo kho hàng đầu tiên để bắt đầu!</p>
                                        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Tạo kho hàng đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
