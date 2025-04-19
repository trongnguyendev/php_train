<?php 
session_start();
$erName = $_SESSION['errer_name'] ?? '';
unset($_SESSION['errer_name']);
$mail = $_SESSION['errer_mail'] ?? '';
unset($_SESSION['errer_mail']);
$age = $_SESSION['errer_age'] ?? '';
unset($_SESSION['errer_age']);
$name = $_SESSION['name'] ?? '';
unset($_SESSION['name']);
?>
<form action="process.php" method="POST">
<?php
    if(isset($erName)):
        echo $erName;
?>
<?php endif; ?>
<br>
<lable for="name" >Tên: </lable>
<input type="text" name="name" value="<?php echo $name; ?>">
<br>
<?php
    if(isset($mail)):
        echo $mail;

?>
<?php endif; ?>
<br>
<lable for="mail">Email:</lable>
<input type="email" name="mail">
<br>
<?php
    if(isset($age)):
        echo $age;

?>
<?php endif; ?>
<br>
<lable for="age">Tuổi:</lable>
<input type="number" name="age" min="1" max= "100">
<br>
<button type="submit">Gửi</button>
</form>