<?php
session_start();

$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'email' => $_SESSION['errors']['error_email'] ?? '',
    'phone' => $_SESSION['errors']['error_phone'] ?? '',
];

$oldInput = $_SESSION['old_input'] ?? [
    'name' =>'',
    'birthday' =>'',
    'email' =>'',
    'phone' =>'',
    'address' =>'',
];

unset(
    $_SESSION['errors'],
    $_SESSION['old_input'],
);

function oldInput ($field,$oldInput){
    return htmlspecialchars($oldInput[$field] ?? '');
}

function displayError ($field , $errors)
{
    if(!empty($errors[$field]))
    echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
}


require_once '../models/employee.php';
$employee = new Employee();
$idIndex = $_GET['id'] ?? '';

$employeeData = $employee->findRowByIndex($idIndex);
require_once '../views/employee/update.php';
