<?php
// require_once ('./class.php');
// $session = new Show_Error();
session_start();
$brithday = $_SESSION['errer_brithday'] ?? '';
unset($_SESSION['errer_brithday']);
$salary = $_SESSION['errer_salary'] ?? '';
unset($_SESSION['errer_salary']);


require_once './view/form.php'
?>

    