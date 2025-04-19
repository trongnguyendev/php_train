<?php
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

//  Hàm tiện tích để hiển thị giá trị cũ input

function oldinput($field, $oldInput){
    return htmlspecialchars($oldInput[$filed] ?? '');
}

// Hàm tiện ích hiển thị lỗi 

function displayError($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error" . htmlspecialchars($errors[$field]) . "</p>";
    }
}



require_once('../views/user/create.php');