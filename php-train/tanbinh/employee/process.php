<?php
require_once '../models/employee.php';
$employee = new Employee();


$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$phone = $_POST['phone'] ?? '';

$dataStore = [
    'name' => $name,
    'email' => $email,
    'address' => $address,
    'birthday' => $birthday,
    'phone' => $name,
];

$store = $employee->store($dataStore);
if($store){
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}

