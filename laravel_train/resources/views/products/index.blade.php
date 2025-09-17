@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-box-seam text-primary"></i>
                        Quản lý Sản phẩm
                    </h1>
                    <p class="text-muted">Quản lý tất cả sản phẩm trong hệ thống một cách dễ dàng</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i>
                    Thêm Sản phẩm mới
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
                <h3>{{ $products->count() }}</h3>
                <p>Tổng số sản phẩm</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h3>{{ $products->where('price', '>', 0)->count() }}</h3>
                <p>Sản phẩm có giá</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                <h3>{{ $products->count() }}</h3>
                <p>Đang hiển thị</p>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Danh sách Sản phẩm
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-box me-1"></i>Tên sản phẩm</th>
                            <th><i class="bi bi-upc me-1"></i>Mã sản phẩm</th>
                            <th><i class="bi bi-currency-dollar me-1"></i>Giá</th>
                            <th><i class="bi bi-card-text me-1"></i>Mô tả</th>
                            <th><i class="bi bi-calendar me-1"></i>Ngày tạo</th>
                            <th><i class="bi bi-gear me-1"></i>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $product->id }}</span>
                                </td>
                                <td class="fw-bold">{{ $product->name }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                <td>{{ Str::limit($product->description, 50) }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $product->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa"
                                                    onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-emoji-frown display-1"></i>
                                        <h4 class="mt-3">Không có sản phẩm nào</h4>
                                        <p class="mb-3">Hãy thêm sản phẩm đầu tiên để bắt đầu!</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Tạo sản phẩm đầu tiên
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
