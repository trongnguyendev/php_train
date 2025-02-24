<?php
function renderLayout($pageTitle, $content) {
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <h1>Quản lý Người Dùng</h1>
        <nav>
            <a href="users.php">Danh sách người dùng</a> |
            <a href="login.php">Đăng nhập</a> |
            <a href="register.php">Đăng ký</a>
        </nav>
        <hr>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <hr>
        <p>&copy; 2024 - Quản lý Users</p>
    </footer>
</body>
</html>
<?php
}
?>