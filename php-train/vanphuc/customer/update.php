<?php
require_once ('../models/customer.php');

$customer = new Customer();
$indexData = $_GET['id'] ?? 0;

$customerData = $customer->findRowByIndex($indexData);

require_once ('../views/customer/update.php');

