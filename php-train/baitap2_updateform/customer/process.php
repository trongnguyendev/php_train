<?php
require_once('../models/Employee.php');
$name = $_POST['name'];
$email = $_POST['email'];
$brithday = $_POST['brithday'];
$customer = $_POST['customer'];
$data = [
    'name' => $name,
    'email' => $email,
    'birthday' => $brithday,
    'customer' => $customer
];

$getEmployee = new Employee();
$getEmployee->customer($data);
