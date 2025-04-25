<?php
require_once '../models/employee.php';
session_start();
$employee = new Employee();

$name = $_POST['name'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

$dataStore = [
    'name' => $name,
    'birthday' => $birthday,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
];

$store = $employee->store($dataStore);
if($store) {
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}

