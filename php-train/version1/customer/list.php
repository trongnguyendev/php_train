<?php
require_once '../models/customer.php';
$customer = new Customer();
$customers = [];

if($customer) {
    $customers = $customer->all();
}
require_once '../views/customer/list.php';