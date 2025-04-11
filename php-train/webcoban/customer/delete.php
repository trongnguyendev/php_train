<?php

require_once '../models/customer.php';
$customer = new customer();

$indexData = $_GET['id'];

$isDeleted = $customer->delete($indexData);

if ($isDeleted) {
    header("Location: list.php");
    exit;
}