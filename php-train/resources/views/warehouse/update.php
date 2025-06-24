<div class="update">
    <form action="/warehouse/edit/<?= $indexData ?>" method="POST" enctype="multipart/form-data">
        <label for="name">KHO:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($warehouseData['name'] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="location">Vị Trí:</label>
        <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($warehouseData['location'] ?? $oldInput['location'] ?? ''); ?>">
        <?php if (isset($errors['location'])): ?>
            <p class='error'><?= implode(', ', $errors['location']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập Nhật KHO</button>
        <a class="link-back" href="/product">← Quay lại danh sách</a>
    </form>
</div>