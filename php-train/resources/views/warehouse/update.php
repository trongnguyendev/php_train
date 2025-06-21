<div class="update">
    <form action="/product/edit/<?= $indexData ?>" method="POST" enctype="multipart/form-data">
        <label for="name">KHO:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productData['name'] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="localtion">Vị Trí:</label>
        <input type="text" name="localtion" id="localtion" value="<?php echo htmlspecialchars($productData['localtion'] ?? $oldInput['localtion'] ?? ''); ?>">
        <?php if (isset($errors['localtion'])): ?>
            <p class='error'><?= implode(', ', $errors['localtion']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập Nhật KHO</button>
        <a class="link-back" href="/product">← Quay lại danh sách</a>
    </form>
</div>