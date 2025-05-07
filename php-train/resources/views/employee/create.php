<div class="create">
    <form action="/employee/create" method="POST">
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

        <label for="age">Tuổi:</label>
        <input type="number" name="age" id="age" min="1" max="100" value="<?= $oldInput['age'] ?? '' ?>">
        <?php if (isset($errors['age'])): ?>
            <p class='error'><?= implode(', ', $errors['age']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/employee">← Quay về danh sách</a>
    </form>
</div>