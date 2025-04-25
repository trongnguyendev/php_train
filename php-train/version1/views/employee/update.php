
<div class="update">
<form action="process_update.php" method="POST">
    <label for="name">Tên Nhân Viên</label>
    <?php displayError('name', $errors);?>
    <input type="text" name="name" value="<?php echo htmlspecialchars($employeeData[0] ?? ''); ?>">

    <label for="birthday">Ngày Sinh</label>
    <input type="date" name="birthday" value="<?php echo htmlspecialchars($employeeData[1] ?? ''); ?>">

    <label for="email">Email</label>
    <?php displayError('email', $errors);?>
    <input type="email" name="email" value="<?php echo htmlspecialchars($employeeData[2] ?? ''); ?>">

    <label for="phone">Số Điện Thoại</label>
    <?php displayError('phone', $errors);?>
    <input type="number" name="phone" value="<?php echo intval($employeeData[3] ?? ''); ?>">

    <label for="address">Địa Chỉ</label>
    <input type="text" name="address" value="<?php echo htmlspecialchars($employeeData[4] ?? ''); ?>">

    <input type="hidden" name="index" value="<?php echo $idIndex; ?>">

    <button type="submit">Gửi</button>
</form>
</div>