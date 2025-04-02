<?php
session_start();
$name = $_POST['name'];
$email = $_POST['email'];
$brithday = $_POST['brithday'];
$salary = $_POST['salary'];

$hasProcess = true;
if($brithday == ''){
    $_SESSION['errer_brithday'] = "Chưa điền ngày sinh";
}
if($salary == ''){
    $_SESSION['errer_salary'] = "Chưa điền tiền lương";
}
if($brithday === '' || $salary === ''){
    $hasProcess = false;
    header("Location: index.php");
}
if($hasProcess){
$file = fopen("dulieu.txt", "a"); // Mở file để ghi tiếp
fwrite($file, "$name,$email,$brithday,$salary\n");
fclose($file);

header("Location: show.php");
}