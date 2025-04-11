<div class="create">
    <form action="process.php" method="POST">
        <label for="name">Tên:</label>
        <?php displayError('name', $errors); ?>
        <input type="text" name="name" id="name" value="<?= oldInput('name', $oldInput) ?>">

        <label for="phone">Số Điện Thoại:</label>
        <?php displayError('phone', $errors); ?>
        <input type="number" name="phone" id="phone" value="<?= oldInput('phone', $oldInput) ?>">

        <label for="address">Địa Chỉ:</label>
        <?php displayError('address', $errors); ?>
        <input type="text" name="address" id="address" value="<?= oldInput('address', $oldInput) ?>">

        <label for="province">Tỉnh:</label>
        <?php displayError('province', $errors); ?>
        <input type="text" name="province" id="province" value="<?= oldInput('province', $oldInput) ?>">

        <label for="quantity">Số Lượng:</label>
        <?php displayError('quantity', $errors); ?>
        <input type="number" name="quantity" id="quantity" value="<?= oldInput('quantity', $oldInput) ?>">

        <label for="product">Sản Phẩm:</label>
        <?php displayError('product', $errors); ?>
        <input type="text" name="product" id="product" value="<?= oldInput('product', $oldInput) ?>">

        <button type="submit">Gửi</button>

        <a class="link" href="list.php">← Quay về danh sách</a>
    </form>
</div>