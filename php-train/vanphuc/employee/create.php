<?php
$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'age' => $_SESSION['errors']['error_age'] ?? '',
    'email' => $_SESSION['errors']['error_email'] ?? '',
    'phone' => $_SESSION['errors']['error_phone'] ?? '',
];

// Lấy dữ liệu input cũ từ session
$oldInput = $_SESSION['old_input'] ?? [
    'name' => '',
    'age' => '',
    'email' => '',
    'phone' => '',
];

// Xóa cac biến lỗi và dữ liệu 

unset(
    $_SESSION['errors'],
    $_SESSION['old_input']
);

//  Hàm tiện tích để hiển thị giá trị cũ input

function oldinput($fields, $oldInput){
    return htmlspecialchars($oldInput[$filed] ?? '');
}

// Hàm tiện ích hiển thị lỗi 

function displayError($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error" . htmlspecialchars($errors[$field]) . "</p>";
    }
}

require_once('../views/employee/create.php');