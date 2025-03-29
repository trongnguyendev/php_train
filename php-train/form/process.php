<?php
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$error = '';

if ($name == '') {
    $_SESSION['error_name'] = 'Chưa nhập tên';
}
if ($email == '') {
    $_SESSION['error_email'] = 'Chưa nhập email';
}
if ($age == '') {
    $_SESSION['error_age'] = 'Chưa nhập age';
}

$file = fopen("data.txt", "a"); // Mở file để ghi tiếp
fwrite($file, $name . "," . $email . "," . $age . "\n");
fclose($file);

header("Location: index.php");


// echo "Tên: " . $name;
// echo "Mail: " . $email;
// echo "Tuổi: " . $age;