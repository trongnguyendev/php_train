<div class="create">
    <form action="/product/create" method="POST" enctype="multipart/form-data">
        <label for="code">Mã Sản Phẩm:</label>
        <input type="text" name="code" id="code" value="<?= $oldInput['code'] ?? '' ?>">
        <?php if (isset($errors['code'])): ?>
            <p class='error'><?= implode(', ', $errors['code']) ?></p>
        <?php endif;  ?>

        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="description">Mô Tả:</label>
        <input type="text" name="description" id="description"  value="<?= $oldInput['description'] ?? '' ?>">
        <?php if (isset($errors['description'])): ?>
            <p class='error'><?= implode(', ', $errors['description']) ?></p>
        <?php endif;  ?>

         <label for="unit">Đơn Vị:</label>
        <input type="text" name="unit" id="unit"  value="<?= $oldInput['unit'] ?? '' ?>">
        <?php if (isset($errors['unit'])): ?>
            <p class='error'><?= implode(', ', $errors['unit']) ?></p>
        <?php endif;  ?>

        <label for="price">Giá :</label>
        <input type="number" name="price" id="price">
        <?php if (isset($errors['price'])): ?>
            <p class='error'><?= implode(', ', $errors['price']) ?></p>
        <?php endif;  ?>

         <label for="image">Hình Ảnh :</label>
        <input type="file" name="image" id="image">
        <?php if (isset($errors['image'])): ?>
            <p class='error'><?= implode(', ', $errors['image']) ?></p>
        <?php endif;  ?>


        <button type="submit">Gửi</button>

        <a class="link" href="/product">← Quay về danh sách</a>
    </form>
</div>