<div class="update">
    <form action="process_update.php" method="POST">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($employeeData[0] ?? ''); ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($employeeData[1] ?? ''); ?>">

        <label for="age">Tuổi:</label>
        <input type="number" name="age" id="age" value="<?php echo intval($employeeData[2] ?? 0); ?>">

        <input type="hidden" name="index" value="<?php echo $indexData; ?>">

        <button type="submit">Cập nhật</button>
        <a class="link-back" href="/employee/list.php">← Quay lại danh sách</a>
    </form>
</div>