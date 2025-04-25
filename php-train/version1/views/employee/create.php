<div class="create">
    <form action="process.php" method="POST">
        <label for="name">Tên Nhân Viên</label>
        <?php displayError('name', $errors);?>
        <input type="text" name="name">

        <label for="birthday">Ngày Sinh</label>
        <input type="date" name="birthday">

        <label for="email">Email</label>
        <?php displayError('email', $errors);?>
        <input type="email" name="email">

        <label for="phone">Số Điện Thoại</label>
        <?php displayError('phone', $errors);?>
        <input type="number" name="phone">

        <label for="address">Địa Chỉ</label>
        <input type="text" name="address">

        <button type="submit">Gửi</button>
    </form>
</div>