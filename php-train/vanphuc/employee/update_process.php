<?php
require_once '../models/employee.php';
$employee = new Employee();
$indexUpdate = $_POST['index'] ?? '';
$dataUpdate = [
    'name' => $_POST['name'],
    'age' => $_POST['age'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
];

$idUpdate = $employee->update($indexUpdate, $dataUpdate);



if($idUpdate){
    header('Location: list.php');
    exit;
}else {
    header('Location: Update.php');
}

