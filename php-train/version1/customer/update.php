<?php
require_once '../models/customer.php';
$customer = new Customer();
$idUpdate = $_GET['id'] ?? '';

$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'phone' => $_SESSION['errors']['error_phone'] ?? '',
    'address' => $_SESSION['errors']['error_address'] ?? '',

];

function displayErrors($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
    }

}

$customers = $customer->findRowbyIndex($idUpdate);
require_once '../views/customer/update.php';

