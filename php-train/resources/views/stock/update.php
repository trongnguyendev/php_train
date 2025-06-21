<div class="update">
    <form action="/stocks/edit/<?= $indexData ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productData['name'] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="warehouse">Kho:</label>
        <input type="text" name="warehouse" id="warehouse" value="<?php echo htmlspecialchars($productData['warehouse'] ?? $oldInput['warehouse'] ?? ''); ?>">
        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo intval($productData['quantity'] ?? $oldInput['quantity'] ?? 0); ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

    

        <button type="submit">Cập Nhật Sản Phẩm</button>
        <a class="link-back" href="/stocks">← Quay lại danh sách</a>
    </form>
</div>