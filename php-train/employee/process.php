<?php
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$brithday = $_POST['brithday'];
$salary = $_POST['salary'];


if($name == ''){
    
    $_SESSION['errer_name'] = "Chưa Điền Tên";
}
if($email == ''){
    $_SESSION['errer_email'] = "Chưa Điền Email";
}
if($brithday == ''){
    $_SESSION['errer_brithday'] = "Chưa Điền Ngày Sinh";
}
if($salary == ''){
    $_SESSION['errer_salary'] = "Chưa Điền Tiền Lương";
}
if($brithday ==='' || $salary === ''){
    header("Location: index.php");
    exit;
}

$file = fopen("dataa.txt", "a"); // Mở file để ghi tiếp
fwrite($file, "$name , $email , $brithday , $salary\n");
fclose($file);

header("Location: list.php");
?>