<?php
require_once('../models/Employee.php');
session_start();
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
$datas = new employee();
$datas->session($infor);
$datas->store($infor);
header ("Location: list.php");