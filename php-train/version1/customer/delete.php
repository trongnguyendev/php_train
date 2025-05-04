<?php
require_once '../models/customer.php';
$customer = new Customer();
$idDelete = $_GET['id'] ?? '';

$customerDelete = $customer->delete($idDelete);

if($customerDelete){
    header("Location: list.php");
}