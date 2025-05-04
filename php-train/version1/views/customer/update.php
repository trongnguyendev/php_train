<div class="update">

    <form action="process_update.php" method="POST">
        <label for="name">Tên Khách Hàng</label>
        <?php displayErrors('name',$errors);?>
        <input type="text" name="name"  value="<?= htmlspecialchars($customers[0] ?? '');?>">

        <label for="phone">Số Điện Thoại</label>
        <?php displayErrors('phone',$errors);?>
        <input type="number" name="phone" value="<?= htmlspecialchars($customers[1] ?? '');?>">

        <label for="address">Địa Chỉ</label>
        <?php displayErrors('address',$errors);?>
        <input type="text" name="address" value="<?= htmlspecialchars($customers[2] ?? '');?>">

        <label for="quantity">Số Lượng</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($customers[3] ?? '');?>">

        <label for="product">Sản Phẩm</label>
        <input type="text" name="product" value="<?= htmlspecialchars($customers[4] ?? '');?>">

        <label for="warehouse">Kho</label>
        <input type="text" name="warehouse" value="<?= htmlspecialchars($customers[5] ?? '');?>">
        <input type="hidden" name="index" value="<?php echo $idUpdate; ?>">

        <button type="submit">Gửi</button>
    </form>
</div>