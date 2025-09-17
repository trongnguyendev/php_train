@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-person-fill text-primary"></i>
                        Thông tin Người dùng
                    </h1>
                    <p class="text-muted">Xem chi tiết thông tin người dùng trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- User Profile Card -->
            <div class="card fade-in">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Hồ sơ người dùng
                    </h5>
                </div>
                <div class="card-body">
                    <!-- User Avatar Section -->
                    <div class="text-center mb-4">
                        <div class="user-avatar mx-auto mb-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>

                    <!-- User Details -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-2">
                                        <i class="bi bi-hash me-2"></i>
                                        ID người dùng
                                    </h6>
                                    <p class="card-text fw-bold">{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-2">
                                        <i class="bi bi-person me-2"></i>
                                        Tên đầy đủ
                                    </h6>
                                    <p class="card-text fw-bold">{{ $user->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-2">
                                        <i class="bi bi-envelope me-2"></i>
                                        Địa chỉ Email
                                    </h6>
                                    <p class="card-text">
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                            <i class="bi bi-envelope me-1"></i>
                                            {{ $user->email }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-2">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Trạng thái Email
                                    </h6>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Đã xác thực
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Chưa xác thực
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Statistics -->
                    <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-graph-up me-2"></i>
                                Thống kê tài khoản
                            </h5>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="mb-2">
                                        <h4 class="mb-1">{{ $user->created_at->diffForHumans() }}</h4>
                                        <small>Thời gian tham gia</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <h4 class="mb-1">{{ $user->updated_at->diffForHumans() }}</h4>
                                        <small>Cập nhật gần nhất</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Chỉnh sửa
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger"
                                    onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa người dùng này?\n\nHành động này không thể hoàn tác!')">
                                <i class="bi bi-trash me-2"></i>
                                Xóa tài khoản
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card fade-in">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $user->email }}" 
                           class="btn btn-outline-primary">
                            <i class="bi bi-envelope me-2"></i>
                            Gửi Email
                        </a>
                        <a href="{{ route('users.edit', $user) }}" 
                           class="btn btn-outline-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Chỉnh sửa
                        </a>
                        <a href="{{ route('users.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="bi bi-people me-2"></i>
                            Danh sách
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin chi tiết
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <small class="text-muted">Ngày tạo:</small><br>
                            <strong>{{ $user->created_at->format('d/m/Y H:i:s') }}</strong>
                        </div>
                        <div class="col-12 mb-2">
                            <small class="text-muted">Cập nhật lần cuối:</small><br>
                            <strong>{{ $user->updated_at->format('d/m/Y H:i:s') }}</strong>
                        </div>
                        @if($user->email_verified_at)
                            <div class="col-12 mb-2">
                                <small class="text-muted">Email xác thực:</small><br>
                                <strong class="text-success">{{ $user->email_verified_at->format('d/m/Y H:i:s') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- System Info Card -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Thông tin hệ thống
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">User ID:</span>
                        <span class="badge bg-secondary">{{ $user->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Trạng thái:</span>
                        @if($user->email_verified_at)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Loại:</span>
                        <span class="badge bg-primary">User</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
