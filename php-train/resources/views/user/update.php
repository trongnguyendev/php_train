<div class="update">
    <form action="/user/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($userData[1] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData[2] ?? $oldInput['email'] ?? ''); ?>">
        <?php if (isset($errors['email'])): ?>
            <p class='error'><?= implode(', ', $errors['email']) ?></p>
        <?php endif;  ?>

        <label for="phone">Số Điện Thoại:</label>
        <input type="number" name="phone" id="phone" value="<?php echo htmlspecialchars($userData[3] ?? $oldInput['phone'] ?? ''); ?>">
        <?php if (isset($errors['phone'])): ?>
            <p class='error'><?= implode(', ', $errors['phone']) ?></p>
        <?php endif;  ?>

         <label for="province">Tỉnh:</label>
        <input type="text" name="province" id="province" value="<?php echo htmlspecialchars($userData[4] ?? $oldInput['province'] ?? ''); ?>">
    

        <label for="password">Password:</label>
        <input type="text" name="password" id="password" value="<?php echo intval($userData[5] ?? $oldInput['password'] ?? 0); ?>">
        <?php if (isset($errors['password'])): ?>
            <p class='error'><?= implode(', ', $errors['password']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/user">← Quay lại danh sách</a>
    </form>
</div>