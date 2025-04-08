<?php
require_once('../models/Employee.php');
$idUpdate = $_GET['index'];
$dataUpdate = new Employee();
$data = $dataUpdate->getUpdateCus($idUpdate);

require_once '../view/customer/formUpdate.php'
?>
