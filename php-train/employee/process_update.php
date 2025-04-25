<?php

require_once '../models/Employee.php';
$employee = new Employee();

$indexData = $_POST['index'];

$dataUpdate = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'age' => $_POST['age'],
];

$isUpdated = $employee->update($indexData, $dataUpdate);

if ($isUpdated) {
    header("Location: list.php");
    exit;
}