<?php
session_start();

// Lấy các lỗi từ session (nếu có)
$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'email' => $_SESSION['errors']['error_email'] ?? '',
    'age' => $_SESSION['errors']['error_age'] ?? ''
];

// Lấy dữ liệu input cũ từ session (nếu có)
$oldInput = $_SESSION['old_input'] ?? [
    'name' => '',
    'email' => '',
    'age' => '',
];

// Xóa các biến lỗi và dữ liệu input cũ khỏi session sau khi đã sử dụng
unset(
    $_SESSION['errors'],
    $_SESSION['old_input']
);

// Hàm tiện ích để hiển thị giá trị cũ của input
function oldInput($field, $oldInput)
{
    return htmlspecialchars($oldInput[$field] ?? '');
}

// Hàm tiện ích để hiển thị lỗi nếu có
function displayError($field, $errors)
{
    if (!empty($errors[$field])) {
        echo "<p class='error'>" . htmlspecialchars($errors[$field]) . "</p>";
    }
}

$pageTitle = 'Tạo mới nhân viên';
$content = '../views/customer/create.php';
require_once('../views/layouts/default.php');
?>