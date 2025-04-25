<?php
$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'phone' => $_SESSION['errors']['error_phone'] ?? '',
    'address' => $_SESSION['errors']['error_address'] ?? '',
    'quantity' => $_SESSION['errors']['error_quantity'] ?? '',
    'product' => $_SESSION['errors']['error_product'] ?? '',
];
// Lấy dữ liệu input cũ từ session
$oldInput = $_SESSION['old_input'] ?? [
    'name' =>'',
    'phone' => '',
    'address' => '',
    'quantity' => '',
    'product' => '',
];

// xóa các biến lỗi và dữ liệu input cũ khỏi session sau khi đã sử dụng
unset(
    $_SESSION['errors'],
    $_SESSION['old_input']
);

// Hàm tiện ích để hiên thị giá trị cũ của input
function oldinput($field, $oldInput){
    return htmlspecialchars($oldInput[$field] ?? '');
}

// Hàm tiện ích hiển thị lỗi nếu có
function displayError($field, $errors){
    if(!empty($errors[$field])){
        echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
    }
}
$pageTitle = 'Tạo mới khách hàng';
$content = '../views/customer/create.php';
require_once('../views/layouts/default.php');