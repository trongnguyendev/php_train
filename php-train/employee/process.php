<?php

require_once '../models/Employee.php';
$employee = new Employee();

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';

$dataStore = [
    'name' => $name,
    'email' => $email,
    'age' => $age
];

$store = $employee->store($dataStore);
if ($store) {
    header("Location: list.php");
    exit;
} else {
    header("Location: create.php");
}
