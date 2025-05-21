<div class="create">
    <form action="/user/create" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $oldInput['email'] ?? '' ?>">
        <?php if (isset($errors['email'])): ?>
            <p class='error'><?= implode(', ', $errors['email']) ?></p>
        <?php endif;  ?>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password">
        <?php if (isset($errors['password'])): ?>
            <p class='error'><?= implode(', ', $errors['password']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/user">← Quay về danh sách</a>
    </form>
</div>