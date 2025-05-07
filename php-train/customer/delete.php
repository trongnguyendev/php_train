<?php

require_once '../models/Customer.php';
$customer = new Customer();

$indexData = $_GET['id'];

$isDeleted = $customer->delete($indexData);

if ($isDeleted) {
    header("Location: list.php");
    exit;
}