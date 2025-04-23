<div class="update">
    <form action="/employee/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($employeeData[0] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= $errors['name'] ?></p>
        <?php endif;  ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($employeeData[1] ?? $oldInput['email'] ?? ''); ?>">
        <?php if (isset($errors['email'])): ?>
            <p class='error'><?= $errors['email'] ?></p>
        <?php endif;  ?>

        <label for="age">Tuổi:</label>
        <input type="number" name="age" id="age" value="<?php echo intval($employeeData[2] ?? $oldInput['age'] ?? 0); ?>">
        <?php if (isset($errors['age'])): ?>
            <p class='error'><?= $errors['age'] ?></p>
        <?php endif;  ?>

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/employee">← Quay lại danh sách</a>
    </form>
</div>