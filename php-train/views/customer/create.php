<div class="create">
    <form action="process.php" method="POST">
        <label for="name"> Tên Khách Hàng</label>
        <?php displayError('name', $errors); ?>
        <input type="text" name="name" value="<?= oldInput('name', $oldInput) ?>">

        <label for="phone">Số Điện Thoại</label>
        <input type="number" name="phone">

        <label for="address">Địa Chỉ</label>
        <input type="text" name="address">

        <label for="quantity">Số Lượng</label>
        <input type="number" name="quantity">

        <label for="product">Sản Phẩm</label>
        <input type="text" name="product">
        <button type="submit">Gửi</button>
    </form>
</div>