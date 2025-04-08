<?php
require_once '../models/Employee.php';
$employee = new Employee();
$employees = [];

if ($employee) {
  $employees = $employee->all();
}

require_once '../views/employee/list.php';

?>