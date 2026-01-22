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
                        LEAD SYSTEM
                    </h3>
                </div>

                <ul class="list-unstyled components">
                    
                    <li class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <a href="{{ route('report_daily.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span> Báo Cáo Ngày</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <a href="{{ route('report_month.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span> Báo Cáo Tháng</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <a href="{{ route('report_showroom.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span> Báo Cáo Showroom</span>
                        </a>
                    </li>

                    <!-- User Management -->
                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Quản lý Users</span>
                        </a>
                    </li>

                    <!-- Role and Permission Section -->
                    <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="bi bi-shield-check"></i>
                            <span>Quản lý Roles</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                        <a href="{{ route('permissions.index') }}" class="nav-link">
                            <i class="bi bi-key"></i>
                            <span>Quản lý Permissions</span>
                        </a>
                    </li>

                    <!-- Lead Management -->
                    <li class="{{ request()->routeIs('leads.*') ? 'active' : '' }}">
                        <a href="{{ route('leads.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Quản lý Lead</span>
                        </a>
                    </li>

                    <!-- Customer Source Management -->
                    <li class="{{ request()->routeIs('customer_sources.*') ? 'active' : '' }}">
                        <a href="{{ route('customer_sources.index') }}" class="nav-link">
                            <i class="bi bi-building"></i>
                            <span>Quản lý Nguồn khách hàng</span>
                        </a>
                    </li>

                    <!-- Product category Management -->
                    <li class="{{ request()->routeIs('product_categories.*') ? 'active' : '' }}">
                        <a href="{{ route('product_categories.index') }}" class="nav-link">
                            <i class="bi bi-building"></i>
                            <span>Quản lý Danh mục sản phẩm</span>
                        </a>
                    </li>

                     <!-- Sale user Management -->
                    <li class="{{ request()->routeIs('sale_users.*') ? 'active' : '' }}">
                        <a href="{{ route('sale_users.index') }}" class="nav-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Quản lý Sale user</span>
                        </a>
                    </li>

                    <!-- Showroom Management -->
                    <li class="{{ request()->routeIs('showrooms.*') ? 'active' : '' }}">
                        <a href="{{ route('showrooms.index') }}" class="nav-link">
                            <i class="bi bi-building"></i>
                            <span>Quản lý Showroom</span>
                        </a>
                    </li>

                    <!-- Customer status Management -->
                    <li class="{{ request()->routeIs('customer_status.*') ? 'active' : '' }}">
                        <a href="{{ route('customer_status.index') }}" class="nav-link">
                            <i class="bi bi-building"></i>
                            <span>Quản lý Tình trạng khách hàng</span>
                        </a>
                    </li>

                    <!-- Province Management -->
                    <li class="{{ request()->routeIs('provinces.*') ? 'active' : '' }}">
                        <a href="{{ route('provinces.index') }}" class="nav-link">
                            <i class="bi bi-geo-alt"></i>
                            <span>Quản lý Tỉnh/Thành</span>
                        </a>
                    </li>

                    <!-- Customer Type Management -->
                    <li class="{{ request()->routeIs('customer_types.*') ? 'active' : '' }}">
                        <a href="{{ route('customer_types.index') }}" class="nav-link">
                            <i class="bi bi-tags"></i>
                            <span>Quản lý Loại khách hàng</span>
                        </a>
                    </li>

                    <!-- Support Channel Management -->
                    <li class="{{ request()->routeIs('support-channels.*') ? 'active' : '' }}">
                        <a href="{{ route('support-channels.index') }}" class="nav-link">
                            <i class="bi bi-headset"></i>
                            <span>Quản lý Kênh hỗ trợ</span>
                        </a>
                    </li>

                    
                    <li class="mt-3">
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

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="content-wrapper">
                <!-- Top Header (Fixed) -->
                <header class="top-header">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                            <button type="button" id="sidebarCollapse" class="btn btn-sm btn-primary">
                                <i class="bi bi-list"></i>
                            </button>
                            
                            <div class="ms-auto d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <span>{{ auth()->user()->name }}</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}"><i class="bi bi-person me-2"></i> Hồ sơ</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </header>

                <!-- Main Content Area -->
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
             const sidebarCollapse = document.getElementById('sidebarCollapse');
             const sidebar = document.getElementById('sidebar');
             const contentWrapper = document.getElementById('content-wrapper');
             
             if (sidebarCollapse && sidebar && contentWrapper) {
                 sidebarCollapse.addEventListener('click', function() {
                     sidebar.classList.toggle('active');
                     contentWrapper.classList.toggle('active');
                 });
             }

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
