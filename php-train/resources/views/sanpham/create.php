<div class="create">
    <form action="/sanpham/create" method="POST">

        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif;  ?>

        <label for="code">Mã Sản Phẩm:</label>
        <input type="text" name="code" id="code" value="<?= $oldInput['code'] ?? '' ?>">
        <?php if (isset($errors['code'])): ?>
            <p class='error'><?= implode(', ', $errors['code']) ?></p>
        <?php endif;  ?>

        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" value="<?= $oldInput['price'] ?? '' ?>">
        <?php if (isset($errors['price'])): ?>
            <p class='error'><?= implode(', ', $errors['price']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/sanpham">← Quay về danh sách</a>
    </form>
</div>