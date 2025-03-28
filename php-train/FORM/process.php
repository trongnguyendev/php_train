<?php
session_start ();
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['number'];

$hasError = false;
if ($name == ''){
    $hasError = true;
    $_SESSION['error_name'] = "Chưa Nhập Tên";
    
}else {
    $_SESSION['name'] = $name;
}
if ($email == ''){
    $hasError = true;
    $_SESSION['error_email'] = "Chưa Nhập Email";
}
if ($age == ''){
    $hasError = true;
    $_SESSION['error_age'] = "Chưa Nhập Tuổi";
}
if (!$hasError) {
    session_destroy();
}

$file = fopen("data.txt", "a"); // Mở file để ghi tiếp
fwrite($file, "Tên: ". $name . " Email: ". $email . " Tuổi: ". $age . "\n");
fclose($file);


header("Location: index.php");


// echo "Tên: ". $name . "Email: " . $email . "Tuổi: " .  $age;