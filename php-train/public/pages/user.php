<?php
require_once '../classes/User.php';
require_once '../templates/layout.php';

$user = new User();
$users = $user->getUsers();
$user->close();

ob_start();
?>
<h2>Danh sách người dùng</h2>
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['firstname']) ?></td>
                    <td><?= htmlspecialchars($user['lastname']) ?></td>
                    <td>
                        <a href="#">Xem chi tiết</a>
                        <a href="#">Xoá</a>
                        <a href="#">Sửa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Không có người dùng nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
renderLayout("Danh sách Users", $content);
?>