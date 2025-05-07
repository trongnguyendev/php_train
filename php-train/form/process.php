<?php
session_start();
$name = $_POST['tennv'];
$email = $_POST['email'];
$date = $_POST['ngaysinh'];
$luongnv = $_POST['luongnv'];
$error = '';

$validate = true;
if($name == ''){
    $validate = false;
    $_SESSION['error_tennv'] = 'Chưa nhập tên';
}
if($email == ''){
    $validate = false;
    $_SESSION['error_email'] = 'Chưa nhập email';
}
if($date == ''){
    $validate = false;
    $_SESSION['error_ngaysinh'] = 'Chưa nhập ngày sinh';
}
if($luongnv == ''){
    $validate = false;
    $_SESSION['error_luongnv'] = 'Chưa nhập lương';
}


if ($validate) {
    $file = fopen("data.txt", "a"); // Mở file để ghi tiếp
    fwrite($file, "$name,$email,$date,$luongnv\n");
    fclose($file);
}


header("LOCATION: index.php");
// echo "Tên nv" . $name;
// echo "Tuổi" . $age;
// echo "Địa chỉ" . $diachiemail;


