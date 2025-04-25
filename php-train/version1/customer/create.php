<?php
require_once '../models/customer.php';
$customer = new Customer();
session_start();
$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'phone' => $_SESSION['errors']['error_phone'] ?? '',
    'province' => $_SESSION['errors']['error_province'] ?? '',
    'quantity' => $_SESSION['errors']['error_quantity'] ?? '',
    'product' => $_SESSION['errors']['error_product'] ?? '',
];

$oldInput = $_SESSION['old_input'] ?? [
    'name' => '',
    'phone' => '',
    'province' => '',
    'quantity' => '',
    'product' => '',
];

unset(
    $_SESSION['errors'],
    $_SESSION['old_input'],
);

function oldInput($field, $oldInput){
    return htmlspecialchars($oldInput[$field] ?? '');
};

function displayError($field, $errors){
    if(!empty($errors[$field]))
    echo "<p class='errors'>" . htmlspecialchars($errors[$field]) . "</p>";
};

require_once '../views/customer/create.php';