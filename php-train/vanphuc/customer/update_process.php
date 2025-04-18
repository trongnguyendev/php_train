<?php
require_once ('../models/customer.php');
$customer = new Customer();
$indexUpdate = $_POST['index'] ?? 0;
$dataUpdate = [
    'name' => $_POST['name'],
    'phone' => $_POST['phone'],
    'address' => $_POST['address'],
    'quantity' => $_POST['quantity'],
    'product' => $_POST['product'],
];

$idUpdate = $customer->update($indexUpdate , $dataUpdate);

if($idUpdate){
    header("Location: list.php");
    exit;
}