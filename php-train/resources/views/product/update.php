<div class="update">
    <form action="/product/edit/<?= $indexData ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productData['name'] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="sku">Mã Sản Phẩm:</label>
        <input type="text" name="sku" id="sku" value="<?php echo htmlspecialchars($productData['sku'] ?? $oldInput['sku'] ?? ''); ?>">
        <?php if (isset($errors['sku'])): ?>
            <p class='error'><?= implode(', ', $errors['sku']) ?></p>
        <?php endif;  ?>

        <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo intval($productData['quantity'] ?? $oldInput['quantity'] ?? 0); ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

        <label for="warehouse">Kho:</label>
        <input type="text" name="warehouse" id="warehouse" value="<?php echo htmlspecialchars($productData['warehouse'] ?? $oldInput['warehouse'] ?? 0); ?>">
        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="img">Hình ảnh/Video hiện tại:</label>
        <?php
            $imgPath = $productData['image'] ?? ($oldInput['image'] ?? '');
            if ($imgPath) {
                if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $imgPath)) {
                    echo '<div><img src="' . htmlspecialchars($imgPath) . '" alt="Current Image" style="max-width:200px;"></div>';
                } else {
                    echo '<div><a href="' . htmlspecialchars($imgPath) . '" target="_blank">File hiện tại</a></div>';
                }
            }
        ?>
        <label for="img">Chọn file mới (nếu muốn thay đổi):</label>
        <input type="file" name="image" id="img">
        <?php if (isset($errors['image'])): ?>
            <p class='error'><?= implode(', ', $errors['image']) ?></p>
        <?php endif;  ?>

        <button type="submit">Cập Nhật Sản Phẩm</button>
        <a class="link-back" href="/product">← Quay lại danh sách</a>
    </form>
</div>