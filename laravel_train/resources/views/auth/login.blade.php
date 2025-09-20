<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng Nhập - Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <i class="bi bi-people-fill" style="font-size: 4rem; color: #0d6efd;"></i>
                            <h2 class="h3 mb-2">Đăng Nhập</h2>
                            <p class="text-muted">Hệ thống quản lý người dùng Laravel</p>
                        </div>

                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Nhập email của bạn"
                                    required 
                                    autofocus
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock me-1"></i>Mật khẩu
                                </label>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Nhập mật khẩu"
                                    required
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input 
                                    id="remember" 
                                    name="remember" 
                                    type="checkbox" 
                                    class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label for="remember" class="form-check-label">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Đăng Nhập
                                </button>
                            </div>
                        </form>

                        <!-- Demo Account -->
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">Tài khoản demo:</h6>
                            <div class="small text-muted">
                                <div class="mb-1">
                                    <strong>Email:</strong> admin@example.com
                                </div>
                                <div class="mb-2">
                                    <strong>Mật khẩu:</strong> password123
                                </div>
                                <div class="text-center">
                                    <span class="text-muted">Hoặc tạo tài khoản mới trong trang quản lý user</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>