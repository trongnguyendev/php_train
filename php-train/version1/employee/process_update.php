<?php
require_once '../models/employee.php';
session_start();
$employee = new Employee();

$name = $_POST['name'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

$idIndex = $_POST['index'] ?? '';

$dataUpdate = [
    'name' => $name,
    'birthday' => $birthday,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
];

$update = $employee->update( $idIndex , $dataUpdate);

if($update) {
    header("Location: list.php");
    exit;
}else {
    header("Location: update.php");
}
