<div class="create">
    <form action="/product/create" method="POST">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="sku">Mã Sản Phẩm:</label>
        <input type="text" name="sku" id="sku" value="<?= $oldInput['sku'] ?? '' ?>">
        <?php if (isset($errors['sku'])): ?>
            <p class='error'><?= implode(', ', $errors['sku']) ?></p>
        <?php endif;  ?>

        <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity"  value="<?= $oldInput['quantity'] ?? '' ?>">
        <?php if (isset($errors['quantity'])): ?>
            <p class='error'><?= implode(', ', $errors['quantity']) ?></p>
        <?php endif;  ?>

         <label for="warehouse">Kho:</label>
        <input type="text" name="warehouse" id="warehouse"  value="<?= $oldInput['warehouse'] ?? '' ?>">
        <?php if (isset($errors['warehouse'])): ?>
            <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
        <?php endif;  ?>

        <label for="img">Hình Ảnh/Video:</label>
        <input type="file" name="img" id="img"  value="<?= $oldInput['img'] ?? '' ?>">
        <?php if (isset($errors['img'])): ?>
            <p class='error'><?= implode(', ', $errors['img']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/product">← Quay về danh sách</a>
    </form>
</div>