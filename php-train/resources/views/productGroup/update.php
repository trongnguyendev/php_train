<div class="update">
    <form action="/product-group/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productGroup['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($productGroup['price'] ?? ''); ?>">
        <?php if (isset($errors['price'])): ?>
            <p class='error'><?= implode(', ', $errors['price']) ?></p>
        <?php endif;  ?>


        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/product-group">← Quay lại danh sách</a>
    </form>
</div>