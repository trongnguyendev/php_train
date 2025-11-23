@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-people-fill text-primary"></i>
                        Quản lý Người dùng
                    </h1>
                    <p class="text-muted">Quản lý tất cả người dùng trong hệ thống một cách dễ dàng</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-person-plus-fill"></i>
                        Thêm Người dùng mới
                    </a>
                </div>
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

    <!-- Quick Links Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-link-45deg me-2"></i>
                        Liên kết nhanh
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-info">
                            <i class="bi bi-shield-check me-2"></i>
                            Quản lý Roles
                        </a>
                        <a href="{{ route('roles.create') }}" class="btn btn-outline-info">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tạo Role mới
                        </a>
                        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-key me-2"></i>
                            Xem Permissions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card text-center">
                <h3>{{ $users->count() }}</h3>
                <p>Tổng số người dùng</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h3>{{ $users->where('email_verified_at', '!=', null)->count() }}</h3>
                <p>Email đã xác thực</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <h3>{{ $users->where('email_verified_at', null)->count() }}</h3>
                <p>Email chưa xác thực</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                <h3>{{ $users->count() }}</h3>
                <p>Đang hiển thị</p>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Danh sách Người dùng
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-person me-1"></i>Tên</th>
                            <th><i class="bi bi-envelope me-1"></i>Email</th>
                            <th><i class="bi bi-calendar me-1"></i>Ngày tạo</th>
                            <th><i class="bi bi-shield-check me-1"></i>Roles</th>
                            <th><i class="bi bi-gear me-1"></i>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar" style="width: 40px; height: 40px; font-size: 1rem; margin: 0 12px 0 0;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-1"></i>
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->roles->count() > 0)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Chưa có role</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.show', $user) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('users.assign-roles', $user) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Gán roles">
                                            <i class="bi bi-shield-check"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa"
                                                    onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa người dùng này?')">
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
                                        <h4 class="mt-3">Không có người dùng nào</h4>
                                        <p class="mb-3">Hãy tạo người dùng đầu tiên để bắt đầu!</p>
                                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                                            <i class="bi bi-person-plus-fill me-2"></i>
                                            Tạo người dùng đầu tiên
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
