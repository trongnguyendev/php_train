<?php
session_start();

require_once '../models/Customer.php';
$customer = new Customer();

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';

$dataStore = [
    'name' => $name,
    'email' => $email,
    'age' => $age
];

$store = $customer->store($dataStore);
if ($store) {
    header("Location: list.php");
    exit;
} else {
    header("Location: create.php");
}
