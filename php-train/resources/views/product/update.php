<div class="update">
    <form action="/product/edit/<?= $indexData ?>" method="POST">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($employeeData[0] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="sku">Mã Sản Phẩm:</label>
        <input type="text" name="sku" id="sku" value="<?php echo htmlspecialchars($employeeData[1] ?? $oldInput['sku'] ?? ''); ?>">
        <?php if (isset($errors['sku'])): ?>
            <p class='error'><?= implode(', ', $errors['sku']) ?></p>
        <?php endif;  ?>

        <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo intval($employeeData[2] ?? $oldInput['quantity'] ?? 0); ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

        <label for="warehouse">Kho:</label>
        <input type="text" name="warehouse" id="warehouse" value="<?php echo htmlspecialchars($employeeData[3] ?? $oldInput['warehouse'] ?? 0); ?>">
        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="img">Hình ảnh/Video:</label>
        <input type="img" name="img" id="img" value="<?php echo htmlspecialchars($employeeData[4] ?? $oldInput['img'] ?? 0); ?>">
        <?php if (isset($errors['img'])): ?>
            <p class='error'><?= implode(', ', $errors['img']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập Nhật Sản Phẩm</button>
        <a class="link-back" href="/product">← Quay lại danh sách</a>
    </form>
</div>