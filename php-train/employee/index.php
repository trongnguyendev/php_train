<?php
session_start();
$errer_name = $_SESSION['errer_name'] ?? '';
unset($_SESSION['errer_name']);
$errer_email = $_SESSION['errer_email'] ?? '';
unset($_SESSION['errer_email']);
$errer_brithday = $_SESSION['errer_brithday'] ?? '';
unset($_SESSION['errer_brithday']);
$errer_salary = $_SESSION['errer_salary'] ?? '';
unset($_SESSION['errer_salary']);
?>


<form action="process.php" method="POST">

<label for="name">Tên Nhân Viên:</label>
<input type="text" name="name" required>
<br>
<label for="email">Email:</label>
<input type="email" name="email" required>
<?php if(isset($errer_brithday)):?>
    <p><?php echo $errer_brithday; ?></p>
    <?php endif;?>
<label for="brithday">Ngày Sinh:</label>
<input type="date" name="brithday">
<?php if(isset($errer_salary)):?>
    <p><?php echo $errer_salary; ?></p>
    <?php endif;?>
<label for="salary">Lương:</label>
<input type="number" name="salary">
<br>
<button type="submit">Gửi</button>
</form>
<a href = "list.php"> List </a>