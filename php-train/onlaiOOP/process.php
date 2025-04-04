<?php
require_once('./class/Employee.php');
session_start();
$name =$_POST['name'];
$email =$_POST['email'];
$birthday =$_POST['birthday'];
$salary =$_POST['salary'];
$datas = [
    'name' => $name,
    'email' => $email,
    'birthday' => $birthday,
    'salary' => $salary
];

$store = new Employee();
$store->store($datas);
// if($birthday == ''){
//     $_SESSION['error_birthday'] = "Chưa Điền Ngày Sinh";
//     header ("Location:index.php");
// }
// if($salary == ''){
//     $_SESSION['error_salary'] = "Chưa Điền Lương";
//     header ("Location:index.php");
// }
// if($birthday == '' || $salary == ''){
//     header ("Location:index.php");
// }else {
//     $file = fopen("data.txt", "a"); // Mở file để ghi tiếp
//     fwrite($file,"$name,$email,$birthday,$salary\n");
//     fclose($file);

//     header ("Location:list.php");
// }