@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-geo-alt-fill text-primary"></i>
                        Quản lý Tỉnh
                    </h1>
                    <p class="text-muted">Quản lý tất cả tỉnh thành trong hệ thống</p>
                </div>
                <a href="{{ route('province.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i>
                    Thêm Tỉnh Mới
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3"> 
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Thành công!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Province Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-table me-2"></i>Danh sách Tỉnh</h5>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tên Tỉnh Thành</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($provinces as $province)
                            <tr>
                                <td>{{ $province->name }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('province.edit', $province) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('province.destroy', $province) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa tỉnh này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-5">
                                    <i class="bi bi-emoji-frown display-1 text-muted"></i>
                                    <h4 class="mt-3">Chưa có tỉnh nào</h4>
                                    <a href="{{ route('province.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Tạo tỉnh đầu tiên
                                    </a>
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
