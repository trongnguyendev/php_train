<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Trang chủ'; ?></title>
    <link rel="stylesheet" href="../resources/css/style.css">
    <link href="../resources/assets/fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../resources/assets/fontawesome/css/brands.css" rel="stylesheet" />
    <link href="../resources/assets/fontawesome/css/solid.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container-layout">
        <div class="layout row">
            <div class="col-md-2">
                <div class="sidebar">
                    <h2 class="menu-title">CRM</h2>
                    <ul class="menu-list">
                        <li><a href="../"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="/employee/list.php"><i class="fa-regular fa-circle-user"></i> Quản lí nhân viên</a></li>
                        <li><a href="/customer/list.php"><i class="fa fa-user-friends"></i> Quản lí khách hàng</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
            <div class="main-content">
                <div class="header">
                    <div class="page-title">
                        <h1><?= $pageTitle ?></h1>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>