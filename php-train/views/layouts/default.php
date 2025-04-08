<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Trang chủ'; ?></title>
    <link rel="stylesheet" href="../resources/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="layout">
            <div class="sidebar">
                <h2 class="menu-title">📋 Menu</h2>
                <ul class="menu-list">
                    <li><a href="#"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fa fa-users"></i> Quản lí nhân viên</a></li>
                    <li><a href="#"><i class="fa fa-user-friends"></i> Quản lí khách hàng</a></li>
                </ul>
            </div>

            <div class="main-content">
                <div class="header">
                    <div class="page-title">
                        <h1><?= $pageTitle ?></h1>
                    </div>
                    <div class="left">
                        <form class="search-form" action="/search.php" method="GET">
                            <input type="text" name="q" placeholder="Tìm kiếm...">
                            <button type="submit">🔍</button>
                        </form>
                    </div>

                    <div class="right">
                        <img src="https://www.svgrepo.com/show/382109/male-avatar-boy-face-man-user-7.svg" alt="Avatar" class="avatar">
                        <div class="user-menu">
                            <span class="username">Tên người dùng</span>
                            <a href="/logout.php" class="logout">Đăng xuất</a>
                        </div>
                    </div>
                </div>

                <div class="page-content">
                    <?php 
                        if (isset($content)) {
                            require_once($content);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>