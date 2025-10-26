<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý Người dùng') - Laravel App</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @auth
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar">
                <div class="sidebar-header">
                    <h3 class="text-white">
                        <i class="bi bi-rocket-takeoff"></i>
                        Laravel App
                    </h3>
                </div>

                <ul class="list-unstyled components">
                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Quản lý Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="bi bi-gear-fill"></i>
                            <span>Cài đặt</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="bi bi-question-circle-fill"></i>
                            <span>Trợ giúp</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Page Content -->
            <div id="content">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-primary">
                            <i class="bi bi-list"></i>
                        </button>
                        
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                    {{ auth()->user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}"><i class="bi bi-person"></i> Hồ sơ</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="main-content">
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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Breadcrumb -->
                    @hasSection('breadcrumb')
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <!-- Login Layout (No Sidebar) -->
        <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
            @yield('content')
        </div>
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
     <!-- Custom JS -->
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             // Sidebar toggle
             document.getElementById('sidebarCollapse').addEventListener('click', function() {
                 document.getElementById('sidebar').classList.toggle('active');
                 document.getElementById('content').classList.toggle('active');
             });

             // Active link highlighting
             const currentPath = window.location.pathname;
             const navLinks = document.querySelectorAll('.sidebar .nav-link');
             
             navLinks.forEach(link => {
                 if (link.getAttribute('href') === currentPath) {
                     link.parentElement.classList.add('active');
                 } else {
                     link.parentElement.classList.remove('active');
                 }
             });

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
         });
     </script>
    @stack('scripts')
</body>
</html>
