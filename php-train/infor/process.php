<?php
session_start();

$name = $_POST['name'];
$email = $_POST['mail'];
$age = $_POST['age'];

    $hasError = false;
if($name == ''){ 
    $hasError = true;
    $_SESSION['errer_name'] = "Bạn Chưa Điền Tên";
}else {
    $_SESSION['name'] = $name;
}

if($email == ''){ 
    $hasError = true;
    $_SESSION['errer_mail'] = "Bạn Chưa Điền Email";
}
if($age == ''){
    $hasError = true;
    $_SESSION['errer_age'] = "Bạn Chưa Điền Tuổi";
}
if (!$hasError){
    session_destroy();
}

$file = fopen("text.txt", "a"); // Mở file để ghi tiếp
fwrite($file, "Tên: ". $name . " Email: ". $email . " Tuổi: ". $age . "\n");
fclose($file);


header("Location: index.php");
// header("Location: list.php");