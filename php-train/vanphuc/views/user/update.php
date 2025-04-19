<div>
    <form action="update_process.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($userData[0] ?? ''); ?>">

        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($userData[1] ?? ''); ?>">

        <label for="lastname">Tên</label>
        <input type="text" name="lastname" value="<?php echo htmlspecialchars($userData[2] ?? ''); ?>">

        <label for="firstname">Họ</label>
        <input type="text" name="firstname" value="<?php echo htmlspecialchars($userData[3] ?? ''); ?>">

        <label for="verified">Xác Thực</label>
        <input type="text" name="verified" value="<?php echo htmlspecialchars($userData[4] ?? ''); ?>">

        <label for="password">Mật Khẩu</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($userData[5] ?? ''); ?>">
        <input type="hidden" name="index" value="<?php echo $indexData; ?>">

        <button type="submit">Cập nhật</button>

        <button type="submit">Gửi</button>

    </form>
</div>