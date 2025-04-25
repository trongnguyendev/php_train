<?php
require_once '../models/employee.php';
$employee = new Employee();

$indexDelete = $_GET['id'];



$idDelete = $employee->delete($indexDelete);
if($idDelete) {
    header("Location: list.php");
    exit;
}else {
    header("Location: create.php");
}