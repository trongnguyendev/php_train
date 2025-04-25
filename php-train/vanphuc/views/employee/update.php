<div class="update">
    <form action="update_process.php" method="POST">
        <label for="name">Tên</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($employeeData[0] ?? ''); ?>">

        <label for="age">Tuổi</label>
        <input type="number" name="age" id="age" value="<?php echo intval($employeeData[1] ?? ''); ?>">

        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($employeeData[2] ?? ''); ?>">

        <label for="phone">Số Điện Thoại</label>
        <input type="number" name="phone" id="phone" value="<?php echo intval($employeeData[3] ?? ''); ?>">

        <input type="hidden" name="index" value="<?php echo $indexData; ?>">

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="list.php">← Quay lại danh sách</a>
    </form>
</div>