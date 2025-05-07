<?php

require_once '../models/Customer.php';
$customer = new Customer();
$customers = [];

if ($customer) {
  $customers = $customer->all();
}
 $pageTitle = 'Danh sách khách hàng';
 $content = '../views/customer/list.php';
 require_once('../views/layouts/default.php');
?>