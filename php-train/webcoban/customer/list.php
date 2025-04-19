<?php
require_once '../models/customer.php';
$customer = new customer();
$customers = [];

if ($customer) {
    $customers = $customer->all();
}

$pageTitle = 'Danh sách nhân viên';
$content = '../views/customer/list.php';
require_once('../views/layouts/default.php');
?>