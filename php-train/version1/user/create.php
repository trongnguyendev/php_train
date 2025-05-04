<?php
session_start();
$errors = [
    'username' => $_SESSION['errors']['error_username'] ?? '',
    'email' => $_SESSION['errors']['error_email'] ?? '',
    'lastname' => $_SESSION['errors']['error_lastname'] ?? '',
    'firstname' => $_SESSION['errors']['error_firstname'] ?? '',
    'verified' => $_SESSION['errors']['error_verified'] ?? '',
    'password' => $_SESSION['errors']['error_password'] ?? '',
];

$oldInput = $_SESSION['old_input'] ?? [
    'username' => '',
    'email' => '',
    'lastname' => '',
    'firstname' => '',
    'verified' => '',
    'password' => '',
];

unset(
    $_SESSION['errors'],
    $_SESSION['old_input']
);

function oldInput($field, $oldInput ){
    return htmlspecialchars($oldInput[$field] ?? '');
}

function displayErrors ($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
    }
}

$pageTitle = 'Danh Sách Nhân Viên';
$content = '../views/user/create.php';
require_once ('../views/layouts/default.php');