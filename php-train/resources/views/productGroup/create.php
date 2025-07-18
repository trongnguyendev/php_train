<div class="create">
    <form action="/product-group/create" method="POST">
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" name="name" id="name" value="<?= $oldInput['name'] ?? '' ?>">
        <?php if (isset($errors['name'])): ?>
            <p class='error'><?= implode(', ', $errors['name']) ?></p>
        <?php endif; ?>

        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" value="<?= $oldInput['price'] ?? '' ?>">
        <?php if (isset($errors['price'])): ?>
            <p class='error'><?= implode(', ', $errors['price']) ?></p>
        <?php endif;  ?>

        <button type="submit">Gửi</button>

        <a class="link" href="/product-group">← Quay về danh sách</a>
    </form>
</div>