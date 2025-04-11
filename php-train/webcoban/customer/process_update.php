<?php

session_start();

require_once '../models/customer.php';
$customer = new customer();

$indexData = $_POST['index'];

$dataUpdate = [
    'name' => $_POST['name'],
    'phone' => $_POST['phone'],
    'address' => $_POST['address'],
    'province' => $_POST['province'],
    'quantity' => $_POST['quantity'],
    'product' => $_POST['product'],
];

$isUpdated = $customer->update($indexData, $dataUpdate);

if ($isUpdated) {
    header("Location: list.php");
    exit;
}