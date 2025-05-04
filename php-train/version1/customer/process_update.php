<?php 
require_once '../models/customer.php';
session_start();
$customer = new Customer();
$idIndex = $_POST['index'] ?? 0;

$dataUpdate = [
    'name' => $_POST['name'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'address' => $_POST['address'] ?? '',
    'quantity' => $_POST['quantity'] ?? '',
    'product' => $_POST['product'] ?? '',
    'warehouse' => $_POST['warehouse'] ?? '',
];

$customerData = $customer->update($idIndex, $dataUpdate);

if($customerData){
    header("Location: list.php");
    exit;
}