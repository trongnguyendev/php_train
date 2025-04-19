<?php

require_once '../models/customer.php';
$customer = new customer();

$indexData = $_GET['id'] ?? 0;
$customerData = $customer->findRowByIndex($indexData);

$pageTitle = 'Cập nhật nhân viên';
$content = '../views/customer/update.php';
require_once('../views/layouts/default.php');
?>