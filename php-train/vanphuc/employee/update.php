<?php
require_once '../models/employee.php';
$employee = new Employee();
$indexData = $_GET['id'] ?? 0;
$employeeData = $employee->findRowByIndex($indexData);
require_once ('../views/employee/update.php');