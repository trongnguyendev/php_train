<?php
require_once '../models/employee.php';
$employee = new employee();
$indexDelete = $_GET['id'];

$isDelete = $employee->delete($indexDelete);

if($isDelete){
    header("Location: list.php");
    exit;
}