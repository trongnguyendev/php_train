<div>
    <form action="process.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username">

        <label for="email">Email</label>
        <input type="email" name="email">

        <div class="row">
            <div class="col-md-6">
                <label for="lastname">Tên</label>
                <input type="text" name="lastname">
            </div>
            <div class="col-md-6">
                <label for="firstname">Họ</label>
                <input type="text" name="firstname">
            </div>
        </div>

        <label for="password">Mật Khẩu</label>
        <input type="password" name="password">

        <label for="role">Quyền</label>
        <select name="role" class="type_search">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role[0] ?>">
                    <?= $role[0] . ' - ' . $role[1] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Gửi</button>

    </form>
</div>