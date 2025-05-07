<?php
session_start();

$error_tennv = $_SESSION['error_tennv'] ?? '';
unset($_SESSION['error_tennv']);

$error_email = $_SESSION['error_email'] ?? '';
unset($_SESSION['error_email']);

$error_date = $_SESSION['error_ngaysinh'] ?? '';
unset($_SESSION['error_ngaysinh']);

$error_luongnv = $_SESSION['error_luongnv'] ?? '';
unset($_SESSION['error_luongnv']);
?>

<style>
    label {
    width: 50%;
    display: table;
    margin-bottom: 10px;
    margin-top: 10px;
}
input[type="submit"] {
    margin-top: 15px;
}
</style>

<form action="process.php" method="POST">
    <?php if(isset($error_tennv)): ?>
    <p style="color: red"><?php echo $error_tennv; ?></p>
    <?php endif; ?>
    <label for="name">Tên nhân viên:</label>
    <input type="text" name="tennv" id="name">
    <br>

    <?php if(isset($error_email)): ?>
    <p style="color: red"><?php echo $error_email; ?></p>
    <?php endif; ?>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <br>

    <?php if(isset($error_date)): ?>
    <p style="color: red"><?php echo $error_date; ?></p>
    <?php endif; ?>
    <label for="ngaysinh">Ngày sinh:</label>
    <input type="date" name="ngaysinh" id="ngaysinh">
    <br>

    <?php if(isset($error_luongnv)): ?>
    <p style="color:red"><?php echo $error_luongnv; ?></p>
    <?php endif; ?>
    <label for="luongnv">Lương nhân viên:</label>
    <input type="number" name="luongnv" id="luongnv">
    <br>
    <input type="submit" value="Đăng ký thông tin">
</form>
<a href="http://localhost:9000/form/list.php">LIST</a>