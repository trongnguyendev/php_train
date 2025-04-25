<?php
require_once '../models/customer.php';
session_start();
$customer = new Customer();
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$province = $_POST['province'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$product = $_POST['product'] ?? '';

$dataStore = [
    'name' => $name,
    'phone' => $phone,
    'province' => $province,
    'quantity' => $quantity,
    'product' => $product,
];

$store = $customer->store($dataStore);

if($store){
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}