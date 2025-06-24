<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Trang chủ'; ?></title>
    <link rel="stylesheet" href="/resources/css/style.css">
    <link href="/resources/assets/fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="/resources/assets/fontawesome/css/brands.css" rel="stylesheet" />
    <link href="/resources/assets/fontawesome/css/solid.css" rel="stylesheet" />
</head>
<body>
    <div class="sidebar">
        <div class="logo">CRM</div>
        <nav>
            <ul>
                <li><a href="/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="/employee"><i class="fa-regular fa-circle-user"></i> Quản lí nhân viên</a></li>
                <li><a href="/customer"><i class="fa fa-user-friends"></i> Quản lí khách hàng</a></li>
                <li><a href="/user"><i class="fa-solid fa-user-tie"></i> Quản lí tài khoản</a></li>
                <li><a href="/product"><i class="fa-solid fa-store"></i> Quản lí sản phẩm</a></li>
                <li><a href="/stock"><i class="fa-duotone fa-regular fa-truck"></i> Quản lí kho</a></li>
            </ul>
        </nav>
    </div>
    <main class="main-content">
        <div class="header">
            <div class="search">
                <!-- Có thể thêm ô tìm kiếm tại đây -->
            </div>
            <div class="right">
                <img src="https://www.svgrepo.com/show/382109/male-avatar-boy-face-man-user-7.svg" alt="Avatar" class="avatar" style="width:40px;height:40px;border-radius:50%;">
                <span class="username"><?= htmlspecialchars($_SESSION['user_info'] ?? 'User') ?></span>
                <a href="/logout" class="logout button">Đăng xuất</a>
            </div>
        </div>
        <div class="page-content">
            <?= $content ?>
        </div>
    </main>
</body>
</html>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>