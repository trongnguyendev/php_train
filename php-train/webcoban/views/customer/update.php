<div class="update">
    <form action="process_update.php" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($customerData[0] ?? ''); ?>">

        <label for="phone">Số Điện Thoại:</label>
        <input type="number" name="phone" id="phone" value="<?php echo intval($customerData[1] ?? ''); ?>">

        <label for="address">Địa Chỉ:</label>
        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($customerData[2] ?? ''); ?>">

        <label for="province">Tỉnh:</label>
        <input type="text" name="province" id="province" value="<?php echo htmlspecialchars($customerData[3] ?? ''); ?>">

        <label for="quantity">Số Lượng:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo intval($customerData[4] ?? ''); ?>">

        <label for="product">Sản Phẩm:</label>
        <input type="text" name="product" id="product" value="<?php echo htmlspecialchars($customerData[5] ?? ''); ?>">

        <input type="hidden" name="index" value="<?php echo $indexData; ?>">

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="list.php">← Quay lại danh sách</a>
    </form>
</div>