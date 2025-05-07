<?php

session_start();

require_once '../models/Customer.php';
$customer = new Customer();

$indexData = $_POST['index'];

$dataUpdate = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'age' => $_POST['age'],
];

$isUpdated = $customer->update($indexData, $dataUpdate);

if ($isUpdated) {
    header("Location: list.php");
    exit;
}