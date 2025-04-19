<?php
require_once('../models/Employee.php');
$name = $_POST['name'];
$email = $_POST['email'];
$brithday = $_POST['brithday'];
$customer = $_POST['customer'];
$idUpdate = $_POST['indexUpdate'];

$datas = [
    'name' => $name,
    'email' => $email,
    'birthday' => $brithday,
    'customer' => $customer
];
$update = new Employee();
$update->readUpdateCus1($idUpdate,$datas);