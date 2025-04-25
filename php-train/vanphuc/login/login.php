<?php 

$errors = [
    'username' => $_SESSION['errors']['error_username'] ?? '',
    'password' => $_SESSION['errors']['error_password'] ?? '',

];

$oldInput = $_SESSION['old_input'] ?? [
    'username' => '',
    'password' => '',
];

unset(
    $_SESSION['errors'],
    $_SESSION['old_input'],
);

function oldinput($field, $oldInput){
    return htmlspecialchars($oldInput[$field] ?? ''); 
}

function displayError($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
    }
}

require_once('../views/login/login.php');