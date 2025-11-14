@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-key text-primary"></i>
                        Quản lý Permissions
                    </h1>
                    <p class="text-muted">Xem danh sách tất cả permissions trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Danh sách Permissions
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
                            <th><i class="bi bi-shield-check me-1"></i>Roles</th>
                            <th><i class="bi bi-file-text me-1"></i>Mô tả</th>
                            <th><i class="bi bi-gear me-1"></i>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $permission->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $permission->name }}</div>
                                </td>
                                <td>
                                    <code class="text-primary">{{ $permission->slug }}</code>
                                </td>
                                <td>
                                    @if($permission->roles->count() > 0)
                                        <span class="badge bg-info">{{ $permission->roles->count() }} roles</span>
                                    @else
                                        <span class="badge bg-secondary">Không có</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $permission->description ?? 'Không có mô tả' }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('permissions.show', $permission) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-emoji-frown display-1"></i>
                                        <h4 class="mt-3">Không có permission nào</h4>
                                        <p class="mb-3">Hãy chạy seeder để tạo permissions!</p>
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

