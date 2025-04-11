<?php
require_once '../models/Employee.php';
$employee = new Employee();
$employees = [];

if ($employee) {
  $employees = $employee->all();
}

$pageTitle = 'Danh sách nhân viên';
$content = '../views/employee/list.php';
require_once('../views/layouts/default.php');
?>