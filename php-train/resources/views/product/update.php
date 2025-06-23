<div class="update">
    <form action="/product/edit/<?= $indexData ?>" method="POST" enctype="multipart/form-data">
        <label for="code">Mã Sản Phẩm:</label>
        <input type="text" name="code" id="code" value="<?php echo htmlspecialchars($productData['code'] ?? $oldInput['code'] ?? ''); ?>">
        <?php if (isset($errors['code'])): ?>
            <p class='error'><?= implode(', ', $errors['code']) ?></p>
        <?php endif;  ?>

        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productData['name'] ?? $oldInput['name'] ?? ''); ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="description">Mô Tả:</label>
        <input type="text" name="description" id="description" value="<?php echo intval($productData['description'] ?? $oldInput['description'] ?? 0); ?>">
        <?php if (isset($errors['description'])): ?>
            <p class='error'><?= implode(', ', $errors['description']) ?></p>
        <?php endif;  ?>

        <label for="unit">Đơn Vị:</label>
        <input type="text" name="unit" id="unit" value="<?php echo htmlspecialchars($productData['unit'] ?? $oldInput['unit'] ?? 0); ?>">
        <?php if (isset($errors['unit'])): ?>
            <p class='error'><?= implode(', ', $errors['unit']) ?></p>
        <?php endif;  ?>


        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($productData['price'] ?? $oldInput['price'] ?? 0); ?>">
        <?php if (isset($errors['price'])): ?>
            <p class='error'><?= implode(', ', $errors['price']) ?></p>
        <?php endif;  ?>

        <label for="image">Hình ảnh/Video hiện tại:</label>
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