<div class="update">
    <form action="/full_bo_sanpham/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($sanphamData[1] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($sanphamData[2] ?? $oldInput['price'] ?? ''); ?>">
        <?php if (isset($errors['price'])): ?>
            <p class='error'><?= implode(', ', $errors['price']) ?></p>
        <?php endif;  ?>


        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/full_bo_sanpham">← Quay lại danh sách</a>
    </form>
</div>