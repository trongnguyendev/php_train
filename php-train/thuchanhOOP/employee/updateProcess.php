<?php
require_once('../models/Employee.php');
$id = $_POST['indexUpdate'];
$name = $_POST['name'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$salary = $_POST['salary'];
$dataUpdate = [
    'name' => $name,
    'email' => $email,
    'birthday' => $birthday,
    'salary' => $salary
];
$datas = new Employee();
$datas->readFileEmployeeUp($id,$dataUpdate);
header ("Location: list.php");