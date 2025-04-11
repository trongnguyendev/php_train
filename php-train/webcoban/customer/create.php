<?php
$errors = [
    'name' => $_SESSION['errors']['error_name'] ?? '',
    'phone' => $_SESSION['errors']['error_phone'] ?? '',
    'address' => $_SESSION['errors']['error_address'] ?? '',
    'province' => $_SESSION['errors']['error_province'] ?? '',
    'quantity' => $_SESSION['errors']['error_quantity'] ?? '',
    'product' => $_SESSION['errors']['error_product'] ?? '',

];
// Lấy dữ liệu input cũ từ session (nếu có)
$oldInput = $_SESSION['old_input'] ?? [
    'name' => '',
    'phone' => '',
    'address' => '',
    'province' => '',
    'quantity' => '',
    'product' => '',
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

$pageTitle = "Nhập Thông Tin Mua Hàng";
$content = '../views/customer/create.php';
require_once('../views/layouts/default.php');