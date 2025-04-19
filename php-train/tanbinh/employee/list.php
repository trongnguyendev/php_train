<?php
require_once '../models/employee.php';
$employee = new Employee();
$employees = [];

if($employee){
    $employees = $employee->all();
}