<?php

require_once '../models/Employee.php';
$employee = new Employee();

$indexData = $_GET['id'] ?? 0;
$employeeData = $employee->findRowByIndex($indexData);

$pageTitle = 'Cập nhật nhân viên';
$content = '../views/employee/update.php';
require_once('../views/layouts/default.php');
?>