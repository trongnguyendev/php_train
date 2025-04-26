<?php

require_once '../models/Role.php';

$errors = [
    'username' => $_POST['errors']['users'] ?? '',
    'email' => $_POST['errors']['email'] ?? '',
    'lastname' => $_POST['errors']['lastname'] ?? '',
    'firstname' => $_POST['errors']['firstname'] ?? '',
    'verified' => $_POST['errors']['is_verified'] ?? '',
    'password' => $_POST['errors']['password'] ?? '',
];

$oldInput = $_SESSION['old_input'] ?? [
    'username' => '',
    'email' => '',
    'lastname' => '',
    'firstname' => '',
    'is_verified' => '',
    'password' => '',
];


unset(
    $_SESSION['errors'],
    $_SESSION['old_input'],
);

$role = new Role();
$roles = $role->all();
//  Hàm tiện tích để hiển thị giá trị cũ input
function oldinput($field, $oldInput){
    return htmlspecialchars($oldInput[$field] ?? '');
}

// Hàm tiện ích hiển thị lỗi 

function displayError($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error" . htmlspecialchars($errors[$field]) . "</p>";
    }
}

$pageTitle = 'Tạo mới user';
$content = '../views/user/create.php';
require_once('../views/layouts/default.php');