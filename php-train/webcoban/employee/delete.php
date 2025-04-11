<?php

require_once '../models/Employee.php';
$employee = new Employee();

$indexData = $_GET['id'];

$isDeleted = $employee->delete($indexData);

if ($isDeleted) {
    header("Location: list.php");
    exit;
}