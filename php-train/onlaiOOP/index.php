<?php
session_start();
$birthday = $_SESSION['error_birthday'] ?? '';
unset($_SESSION['error_birthday']);
$salary = $_SESSION['error_salary'] ?? '';
unset($_SESSION['error_salary']);

?>
<form action="process.php" method="POST">
    <label for="name">Tên Nhân Viên</label>
    <input type="text" name="name" value='' required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" value=''required>
    <br>
    <?php if(isset($birthday)):?>
        <?php echo $birthday;?>
        <?php endif;?>
    <label for="birthday">Ngày Sinh</label>
    <input type="date" name="birthday" value=''>
    <br>
    <?php if(isset($salary)):?>
        <?php echo $salary;?>
        <?php endif;?>
    <label for="salary">Tiền Lương</label>
    <input type="number" name="salary" value=''>
    <br>
    <button type="submit">Nhập Thông Tin</button>
</form>