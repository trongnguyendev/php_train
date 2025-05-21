<div class="update">
    <form action="/user/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($userData[0] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData[1] ?? $oldInput['email'] ?? ''); ?>">
        <?php if (isset($errors['email'])): ?>
            <p class='error'><?= implode(', ', $errors['email']) ?></p>
        <?php endif;  ?>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" value="<?php echo intval($userData[2] ?? $oldInput['password'] ?? 0); ?>">
        <?php if (isset($errors['password'])): ?>
            <p class='error'><?= implode(', ', $errors['password']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/user">← Quay lại danh sách</a>
    </form>
</div>