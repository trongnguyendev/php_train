<?php
require_once ('./class.php');
$session = new Show_Error();
$show =  new showForm ($brithday, $salary);
// $brithday = $_SESSION['errer_brithday'] ?? '';
// unset($_SESSION['errer_brithday']);
// $salary = $_SESSION['errer_salary'] ?? '';
// unset($_SESSION['errer_salary']);
?>
<form action="process.php" method="POST">
    <?php $show->showForm; ?>
    <br>
    <button type="submit">Gửi Thông Tin</button>
</form>
    