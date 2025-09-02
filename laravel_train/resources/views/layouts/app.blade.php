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
                <li class="active">
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
                                Admin
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Hồ sơ</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>

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
        });
    </script>
</body>
</html>
