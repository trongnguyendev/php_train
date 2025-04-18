<?php
require_once '../models/employee.php';
session_start();
$employee = new Employee();

$name = $_POST['name'] ?? '';
$age = $_POST['age'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

$dataStore = [
    'name' => $name,
    'age' => $age,
    'email' => $email,
    'phone' => $phone,
];

$store = $employee->store($dataStore);

if($store){
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}
