<?php
require_once('../models/customer.php');
$id = $_GET['index'];
$delete = new customer();
$delete->deleteCustomer($id);
header ("Location: list.php");