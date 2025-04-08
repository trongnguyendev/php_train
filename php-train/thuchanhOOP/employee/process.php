<?php
require_once('../models/Employee.php');
$name = $_POST['name'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$salary = $_POST['salary'];
$infor = [
    'name'  => $name,
    'email' => $email,
    'birthday' => $birthday,
    'salary' => $salary,
];

$datas = new Employee();
$datas->store($infor);
header ("Location: list.php");