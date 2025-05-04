<div>
    <form action="process_update.php" method="POST">
        <label for="username">Username</label>
        
        <input type="text" name="username" value="<?= htmlspecialchars($users[0] ?? '');?>">
        <?php displayErrors('username', $errors);?>
        <label for="email">Email</label>
        
        <input type="email" name="email" value="<?= htmlspecialchars($users[1] ?? '');?>">
        <?php displayErrors('email', $errors);?>
        <label for="lastname">Tên</label>
        <input type="text" name="lastname" value="<?= htmlspecialchars($users[2] ?? '');?>">

        <label for="firstname">Họ</label>
        <?php displayErrors('firstname', $errors);?>
        <input type="text" name="firstname" value="<?= htmlspecialchars($users[3] ?? '');?>">

        <label for="verified">Xác Thực</label>
        <input type="text" name="verified" value="<?= htmlspecialchars($users[4] ?? '');?>">

        <label for="password">Mật Khẩu</label>
        <?php displayErrors('password', $errors);?>
        <input type="password" name="password" value="<?= htmlspecialchars($users[5] ?? '');?>">
        <input type="hidden" name="index" value="<?php echo $idIndex; ?>">

        <button type="submit">Cập Nhập</button>


    </form>
</div>