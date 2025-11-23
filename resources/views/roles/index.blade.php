@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-shield-check text-primary"></i>
                        Quản lý Roles
                    </h1>
                    <p class="text-muted">Quản lý các vai trò và phân quyền trong hệ thống</p>
                </div>
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle-fill"></i>
                    Thêm Role mới
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

    <!-- Roles Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Danh sách Roles
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-tag me-1"></i>Tên</th>
                            <th><i class="bi bi-link-45deg me-1"></i>Slug</th>
                            <th><i class="bi bi-key me-1"></i>Permissions</th>
                            <th><i class="bi bi-file-text me-1"></i>Mô tả</th>
                            <th><i class="bi bi-gear me-1"></i>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $role->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $role->name }}</div>
                                </td>
                                <td>
                                    <code class="text-primary">{{ $role->slug }}</code>
                                </td>
                                <td>
                                    @if($role->permissions->count() > 0)
                                        <span class="badge bg-info">{{ $role->permissions->count() }} permissions</span>
                                    @else
                                        <span class="badge bg-secondary">Không có</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $role->description ?? 'Không có mô tả' }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('roles.show', $role) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('roles.edit', $role) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa"
                                                    onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa role này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-emoji-frown display-1"></i>
                                        <h4 class="mt-3">Không có role nào</h4>
                                        <p class="mb-3">Hãy tạo role đầu tiên để bắt đầu!</p>
                                        <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle-fill me-2"></i>
                                            Tạo role đầu tiên
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

