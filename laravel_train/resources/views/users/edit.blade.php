@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-pencil-fill text-warning"></i>
                        Chỉnh sửa Người dùng
                    </h1>
                    <p class="text-muted">Cập nhật thông tin người dùng: {{ $user->name }}</p>
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
                        <i class="bi bi-person-fill me-2"></i>
                        Thông tin người dùng
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- User Info Section -->
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-person me-2"></i>
                                    Thông tin cơ bản
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-person me-1"></i>
                                            Tên người dùng
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $user->name) }}" 
                                               placeholder="Nhập tên đầy đủ của người dùng"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Tên hiển thị trong hệ thống
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope me-1"></i>
                                            Địa chỉ Email
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', $user->email) }}" 
                                               placeholder="user@example.com"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Email sẽ được sử dụng để đăng nhập
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-lock me-2"></i>
                                    Cập nhật mật khẩu
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Để trống nếu không muốn thay đổi mật khẩu
                                </p>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">
                                            <i class="bi bi-lock me-1"></i>
                                            Mật khẩu mới
                                        </label>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Mật khẩu phải có ít nhất 8 ký tự
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">
                                            <i class="bi bi-lock-fill me-1"></i>
                                            Xác nhận mật khẩu mới
                                        </label>
                                        <input type="password" 
                                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Nhập lại mật khẩu mới để xác nhận">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Nhập lại mật khẩu để đảm bảo chính xác
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>
                                Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current User Info Card -->
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin hiện tại
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">ID:</span>
                                <span class="badge bg-secondary">{{ $user->id }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Ngày tạo:</span>
                                <span class="fw-bold">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Cập nhật lần cuối:</span>
                                <span class="fw-bold">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Trạng thái email:</span>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Đã xác thực</span>
                                @else
                                    <span class="badge bg-warning">Chưa xác thực</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Lưu ý khi chỉnh sửa
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Email phải là duy nhất trong hệ thống
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Mật khẩu mới phải có ít nhất 8 ký tự
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Nếu không nhập mật khẩu mới, mật khẩu cũ sẽ được giữ nguyên
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Thay đổi sẽ được áp dụng ngay lập tức
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card fade-in mt-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.show', $user) }}" 
                           class="btn btn-outline-primary">
                            <i class="bi bi-eye me-2"></i>
                            Xem thông tin
                        </a>
                        <a href="{{ route('users.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="bi bi-people me-2"></i>
                            Danh sách users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
