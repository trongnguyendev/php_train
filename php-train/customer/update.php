<?php

require_once '../models/Customer.php';
$customer = new Customer();

$indexData = $_GET['id'] ?? 0;
$customerData = $customer->findRowByIndex($indexData);

$pageTitle = 'Cập nhật nhân viên';
$content = '../views/customer/update.php';
require_once('../views/layouts/default.php');
?>