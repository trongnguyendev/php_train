<div class="create">

    <form action="process.php" method="POST">
        <label for="name">Tên Khách Hàng</label>
        <?php displayError('name', $errors);?>
        <input type="text" name="name" value="<?php echo oldInput('name' , $oldInput) ?>">

        <label for="phone">Số Điện Thoại</label>
        <?php displayError('phone', $errors);?>
        <input type="number" name="phone" value="<?php echo oldInput('phone' , $oldInput) ?>">

        <label for="provine">Tỉnh</label>
        <input type="text" name="province" value="<?php echo oldInput('province' , $oldInput) ?>">

        <label for="quantity">Số Lượng</label>
        <input type="number" name="quantity" value="<?php echo oldInput('quantity' , $oldInput) ?>">

        <label for="product">Sản Phẩm</label>
        <?php displayError('products', $errors);?>
        <input type="text" name="product" value="<?php echo oldInput('product' , $oldInput) ?>">

        <button type="submit">Gửi Thông Tin</button>

    </form>
</div>